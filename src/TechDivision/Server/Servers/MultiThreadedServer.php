<?php
/**
 * \TechDivision\Server\Servers\MultiThreadedServer
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Servers
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server\Servers;

use AppserverIo\Logger\LoggerUtils;
use TechDivision\Server\Dictionaries\ModuleVars;
use TechDivision\Server\Dictionaries\ServerVars;
use TechDivision\Server\Interfaces\ServerConfigurationInterface;
use TechDivision\Server\Interfaces\ServerContextInterface;
use TechDivision\Server\Interfaces\ServerInterface;
use TechDivision\Server\Exceptions\ModuleNotFoundException;
use TechDivision\Server\Exceptions\ConnectionHandlerNotFoundException;
use TechDivision\Server\Dictionaries\ServerStateKeys;

/**
 * Class MultiThreadedServer
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Servers
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

class MultiThreadedServer extends \Thread implements ServerInterface
{

    /**
     * Hold's the server context instance
     *
     * @var \TechDivision\Server\Interfaces\ServerContextInterface The server context instance
     */
    protected $serverContext;

    /**
     * TRUE if the server has been started successfully, else FALSE.
     *
     * @var \TechDivision\Server\Dictionaries\ServerStateKeys
     */
    protected $serverState;

    /**
     * Constructs the server instance
     *
     * @param \TechDivision\Server\Interfaces\ServerContextInterface $serverContext The server context instance
     */
    public function __construct(ServerContextInterface $serverContext)
    {

        // set context
        $this->serverContext = $serverContext;

        // start server thread
        $this->start();
    }

    /**
     * Return's the config instance
     *
     * @return \TechDivision\Server\Interfaces\ServerContextInterface
     */
    public function getServerContext()
    {
        return $this->serverContext;
    }

    /**
     * Start's the server's worker as defined in configuration
     *
     * @return void
     *
     * @throws \TechDivision\Server\Exceptions\ModuleNotFoundException
     * @throws \TechDivision\Server\Exceptions\ConnectionHandlerNotFoundException
     */
    public function run()
    {
        // set current dir to base dir for relative dirs
        chdir(SERVER_BASEDIR);

        // setup autoloader
        require SERVER_AUTOLOADER;

        // initialize the server state
        $this->serverState = ServerStateKeys::get(ServerStateKeys::WAITING_FOR_INITIALIZATION);

        // init server context
        $serverContext = $this->getServerContext();

        // init config var for shorter calls
        $serverConfig = $serverContext->getServerConfig();

        // init server name
        $serverName = $serverConfig->getName();

        // initialize the profile logger and the thread context
        if ($profileLogger = $serverContext->getLogger(LoggerUtils::PROFILE)) {
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

        // set socket backlog to 1024 for perform many concurrent connections
        $opts = array(
            'socket' => array(
                'backlog' => 1024,
            )
        );

        // init stream context for server connection
        $streamContext = stream_context_create($opts);
        // check if ssl server config
        if ($serverConfig->getTransport() === 'ssl') {
            stream_context_set_option(
                $streamContext,
                'ssl',
                'local_cert',
                SERVER_BASEDIR . str_replace('/', DIRECTORY_SEPARATOR, $serverConfig->getCertPath())
            );
            stream_context_set_option($streamContext, 'ssl', 'passphrase', $serverConfig->getPassphrase());
            stream_context_set_option($streamContext, 'ssl', 'allow_self_signed', true);
            stream_context_set_option($streamContext, 'ssl', 'verify_peer', false);
        }

        // initialization has been successful
        $this->serverState = ServerStateKeys::get(ServerStateKeys::INITIALIZATION_SUCCESSFUL);

        // setup server bound on local adress
        $serverConnection = $socketType::getServerInstance(
            $serverConfig->getTransport() . '://' . $serverConfig->getAddress() . ':' . $serverConfig->getPort(),
            STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
            $streamContext
        );

        // sockets has been started
        $this->serverState = ServerStateKeys::get(ServerStateKeys::SERVER_SOCKET_STARTED);

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
        $this->serverState = ServerStateKeys::get(ServerStateKeys::MODULES_INITIALIZED);

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
        $this->serverState = ServerStateKeys::get(ServerStateKeys::CONNECTION_HANDLERS_INITIALIZED);

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
        $this->serverState = ServerStateKeys::get(ServerStateKeys::WORKERS_INITIALIZED);

        $logger->info(
            sprintf("%s listing on %s:%s...", $serverName, $serverConfig->getAddress(), $serverConfig->getPort())
        );

        // watch dog for all workers to restart if it's needed while server is up
        while ($this->serverState->equals(ServerStateKeys::get(ServerStateKeys::WORKERS_INITIALIZED))) {

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

            if ($profileLogger) { // profile the worker shutdown beeing processed
                $profileLogger->debug(sprintf('Server %s waiting for shutdown', $serverName));
            }

            // sleep for 1 second to lower system load
            usleep(1000000);
        }
    }
}
