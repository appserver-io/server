<?php

/**
 * \AppserverIo\Server\Servers\MultiThreadedServer
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Servers;

use AppserverIo\Logger\LoggerUtils;
use AppserverIo\Server\Dictionaries\ModuleVars;
use AppserverIo\Server\Dictionaries\ServerVars;
use AppserverIo\Server\Interfaces\ServerConfigurationInterface;
use AppserverIo\Server\Interfaces\ServerContextInterface;
use AppserverIo\Server\Interfaces\ServerInterface;
use AppserverIo\Server\Exceptions\ModuleNotFoundException;
use AppserverIo\Server\Exceptions\ConnectionHandlerNotFoundException;
use AppserverIo\Server\Dictionaries\ServerStateKeys;

/**
 * Class MultiThreadedServer
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

class MultiThreadedServer extends \Thread implements ServerInterface
{

    /**
     * Holds the server context instance
     *
     * @var \AppserverIo\Server\Interfaces\ServerContextInterface The server context instance
     */
    protected $serverContext;

    /**
     * TRUE if the server has been started successfully, else FALSE.
     *
     * @var \AppserverIo\Server\Dictionaries\ServerStateKeys
     */
    protected $serverState;

    /**
     * Constructs the server instance
     *
     * @param \AppserverIo\Server\Interfaces\ServerContextInterface $serverContext The server context instance
     */
    public function __construct(ServerContextInterface $serverContext)
    {
        // initialize the server state
        $this->serverState = ServerStateKeys::WAITING_FOR_INITIALIZATION;
        // set context
        $this->serverContext = $serverContext;
        // start server thread
        $this->start();
    }

    /**
     * Returns the config instance
     *
     * @return \AppserverIo\Server\Interfaces\ServerContextInterface
     */
    public function getServerContext()
    {
        return $this->serverContext;
    }

    /**
     * Shutdown the workers and stop the server.
     */
    public function stop()
    {
        $this->synchronized(function ($self) {
            $self->serverState = ServerStateKeys::HALT;
        }, $this)
    }

    /**
     * Starts the server's worker as defined in configuration
     *
     * @return void
     *
     * @throws \AppserverIo\Server\Exceptions\ModuleNotFoundException
     * @throws \AppserverIo\Server\Exceptions\ConnectionHandlerNotFoundException
     */
    public function run()
    {
        // set current dir to base dir for relative dirs
        chdir(SERVER_BASEDIR);

        // setup autoloader
        require SERVER_AUTOLOADER;

        // init server context
        $serverContext = $this->getServerContext();

        // init config var for shorter calls
        $serverConfig = $serverContext->getServerConfig();

        // init server name
        $serverName = $serverConfig->getName();

        // initialize the profile logger and the thread context
        $profileLogger = null;
        if ($serverContext->hasLogger(LoggerUtils::PROFILE)) {
            $profileLogger = $serverContext->getLogger(LoggerUtils::PROFILE);
            $profileLogger->appendThreadContext($serverName);
        }

        // init logger
        $logger = $serverContext->getLogger();
        $logger->debug(
            sprintf("starting %s (%s)", $serverName, __CLASS__)
        );

        // get class names
        $socketType = $serverConfig->getSocketType();
        $workerType = $serverConfig->getWorkerType();
        $streamContextType = $serverConfig->getStreamContextType();

        // init stream context for server connection
        $streamContext = new $streamContextType();
        // set socket backlog to 1024 for perform many concurrent connections
        $streamContext->setOption('socket', 'backlog', 1024);

        // check if ssl server config
        if ($serverConfig->getTransport() === 'ssl') {
            // get real cert path
            $realCertPath = str_replace('/', DIRECTORY_SEPARATOR, $serverConfig->getCertPath());
            // check if relative or absolute path was given
            if (strpos($realCertPath, '/') === false) {
                $realCertPath = SERVER_BASEDIR . $realCertPath;
            }
            // path to local certificate file on filesystem. It must be a PEM encoded file which contains your
            // certificate and private key. It can optionally contain the certificate chain of issuers.
            $streamContext->setOption('ssl', 'local_cert', $realCertPath);
            $streamContext->setOption('ssl', 'passphrase', $serverConfig->getPassphrase());
            // require verification of SSL certificate used
            $streamContext->setOption('ssl', 'verify_peer', false);
            // allow self-signed certificates. requires verify_peer
            $streamContext->setOption('ssl', 'allow_self_signed', true);
            // set all domain specific certificates
            foreach ($serverConfig->getCertificates() as $certificate) {
                // try to set ssl certificates
                // validation checks are made there and we want the server started in case of invalid ssl context
                try {
                    $streamContext->addSniServerCert($certificate['domain'], $certificate['certPath']);
                } catch (\Exception $e) {
                    // log exception message
                    $logger->error($e->getMessage());
                }
            }
        }

        // inject stream context to server context for further modification in modules init function
        $serverContext->injectStreamContext($streamContext);

        // initialization has been successful
        $this->serverState = ServerStateKeys::INITIALIZATION_SUCCESSFUL;

        // init modules array
        $modules = array();
        // initiate server modules
        $moduleTypes = $serverConfig->getModules();
        foreach ($moduleTypes as $moduleType) {
            // check if module type exists
            if (!class_exists($moduleType)) {
                throw new ModuleNotFoundException($moduleType);
            }
            // instantiate module type
            $module = new $moduleType();
            $moduleName = $module->getModuleName();
            $modules[$moduleName] = $module;

            $logger->debug(
                sprintf("%s init %s module (%s)", $serverName, $moduleType::MODULE_NAME, $moduleType)
            );

            // init module with serverContext (this)
            $modules[$moduleName]->init($serverContext);
        }

        // modules has been initialized successfully
        $this->serverState = ServerStateKeys::MODULES_INITIALIZED;

        // init connection handler array
        $connectionHandlers = array();
        // initiate server connection handlers
        $connectionHandlersTypes = $serverConfig->getConnectionHandlers();
        foreach ($connectionHandlersTypes as $connectionHandlerType) {
            // check if conenction handler type exists
            if (!class_exists($connectionHandlerType)) {
                throw new ConnectionHandlerNotFoundException($connectionHandlerType);
            }
            // instantiate connection handler type
            $connectionHandlers[$connectionHandlerType] = new $connectionHandlerType();

            $logger->debug(
                sprintf("%s init connectionHandler (%s)", $serverName, $connectionHandlerType)
            );

            // init connection handler with serverContext (this)
            $connectionHandlers[$connectionHandlerType]->init($serverContext);
            // inject modules
            $connectionHandlers[$connectionHandlerType]->injectModules($modules);
        }

        // connection handlers has been initialized successfully
        $this->serverState = ServerStateKeys::CONNECTION_HANDLERS_INITIALIZED;

        // setup server bound on local adress
        $serverConnection = $socketType::getServerInstance(
            $serverConfig->getTransport() . '://' . $serverConfig->getAddress() . ':' . $serverConfig->getPort(),
            STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
            $streamContext->getResource()
        );

        // sockets has been started
        $this->serverState = ServerStateKeys::SERVER_SOCKET_STARTED;

        $logger->debug(
            sprintf("%s starting %s workers (%s)", $serverName, $serverConfig->getWorkerNumber(), $workerType)
        );

        // setup and start workers
        $workers = array();
        for ($i = 1; $i <= $serverConfig->getWorkerNumber(); ++$i) {
            $workers[$i] = new $workerType(
                $serverConnection->getConnectionResource(),
                $serverContext,
                $connectionHandlers
            );

            $logger->debug(sprintf("Successfully started worker %s", $workers[$i]->getThreadId()));
        }

        // connection handlers has been initialized successfully
        $this->serverState = ServerStateKeys::WORKERS_INITIALIZED;

        $logger->info(
            sprintf("%s listing on %s:%s...", $serverName, $serverConfig->getAddress(), $serverConfig->getPort())
        );

        // watch dog for all workers to restart if it's needed while server is up
        while ($this->serverState === ServerStateKeys::WORKERS_INITIALIZED) {
            // iterate all workers
            for ($i = 1; $i <= $serverConfig->getWorkerNumber(); ++$i) {
                // check if worker should be restarted
                if ($workers[$i]->shouldRestart()) {
                    $logger->debug(
                        sprintf("%s restarting worker #%s (%s)", $serverName, $i, $workerType)
                    );

                    // unset origin worker ref
                    unset($workers[$i]);
                    // build up and start new worker instance
                    $workers[$i] = new $workerType(
                        $serverConnection->getConnectionResource(),
                        $serverContext,
                        $connectionHandlers
                    );
                }
            }

            if ($profileLogger) {
                // profile the worker shutdown beeing processed
                $profileLogger->debug(sprintf('Server %s waiting for shutdown', $serverName));
            }

            // sleep for 1 second to lower system load
            usleep(1000000);
        }








        // print a message with the number of initialized workers
        $logger->info("Found " . sizeof($workers) . " workers to shutdown!");

        $scheme = '';

        // prepare the URL and the options for the shutdown requests
        switch ($serverConfig->getTransport()) {
            case 'tcp':

                $scheme = 'http'
                break;

            case 'ssl':

                $scheme = 'https'
                break;

            default:

                break;
        }

        $url =  . $scheme . '://' . $serverConfig->getAddress() . ':' . $serverConfig->getPort();
        $opts = array($scheme =>
            array(
                'method'  => 'GET',
                'header'  => array('Content-Type: text/plain', 'Connection: close'),
                'timeout' => 0.5
            )
        );
        $context  = stream_context_create($opts);

        // send requests to close all running workers
        while (@file_get_contents($url, false, $context)) {
            $logger->info("Successfully created client connection to shutdown worker!");
        }

        // kill/unset the worker threads
        foreach ($workers as $key => $worker) {
            $workers[$key]->kill();
            unset($workers[$key]);
        }

        // close the server sockets
        $serverConnection->close();
    }
}
