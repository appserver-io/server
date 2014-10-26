<?php
/**
 * \TechDivision\Server\Standalone
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Server
 * @package   TechDivision_Server
 * @author    Johann Zelger <jz@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server;

/**
 * Class Standalone
 *
 * To use the a server implementation standalone
 *
 * @category  Server
 * @package   TechDivision_Server
 * @author    Johann Zelger <jz@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Server
 */
class Standalone
{

    /**
     * Constructs the standalone bootstrapping
     *
     * @param string $baseDir        The base directory of the server to start in standalone mode
     * @param string $configFile     The servers config file
     * @param string $autoloaderFile The autoloader file to use
     */
    public function __construct($baseDir, $configFile = null, $autoloaderFile = null)
    {
        // check if baseDir has trailing slash and add it if not
        if (substr($baseDir, -1) !== '/') {
            $baseDir .= '/';
        }
        // defines the server basedir
        define('SERVER_BASEDIR', $baseDir);
        // defines the autoloader to use within the server standalone process
        define('SERVER_AUTOLOADER', $autoloaderFile);
        // check if user defined configuration is passed via argv
        if (!is_null($configFile)) {
            define('SERVER_CONFIGFILE', $configFile);
        } else {
            define('SERVER_CONFIGFILE', SERVER_BASEDIR . 'etc/server.xml');
        }
    }

    /**
     * Checks compatibility of environment
     *
     * @return void
     */
    public function checkEnvironment()
    {
        if (!PHP_ZTS) {
            die('This php build is not thread safe. Please recompile with option --enable-maintainer-zts' . PHP_EOL);
        }
        if (!extension_loaded('appserver')) {
            die('Required php extension "appserver" not found. See https://github.com/techdivision/php-ext-appserver' . PHP_EOL);
        }
        if (!extension_loaded('pthreads')) {
            die('Required php extension "appserver" not found. See https://github.com/krakjoe/pthreads' . PHP_EOL);
        }
        if (!is_file(SERVER_CONFIGFILE)) {
            die('Configuration file not exists "' . SERVER_CONFIGFILE . '"'. PHP_EOL);
        }
    }

    /**
     * Starts the server in standalone mode
     *
     * @throws \Exception
     * @return void
     */
    public function start()
    {
        // check environment first
        $this->checkEnvironment();

        // register autoloader if exists
        if (!is_null(SERVER_AUTOLOADER)) {
            require SERVER_AUTOLOADER;
        }

        // check which config format should be used based on file extension
        if ($configType = str_replace('.', '', strrchr(SERVER_CONFIGFILE, '.'))) {
            $mainConfigurationType = '\TechDivision\Server\Configuration\Main' . ucfirst($configType) . 'Configuration';
            // try to instantiate configuration type based on file
            if (class_exists($mainConfigurationType)) {
                $mainConfiguration = new $mainConfigurationType(SERVER_CONFIGFILE);
            } else {
                die("Configuration file '$configType' is not valid or not found.". PHP_EOL);
            }
        } else {
            die("No valid configuration file given." . PHP_EOL);
        }

        // init loggers
        $loggers = array();
        foreach ($mainConfiguration->getLoggerConfigs() as $loggerConfig) {

            // init processors
            $processors = array();
            foreach ($loggerConfig->getProcessors() as $processorType) {
                // create processor
                $processors[] = new $processorType();
            }
            // init handlers
            $handlers = array();
            foreach ($loggerConfig->getHandlers() as $handlerType => $handlerData) {
                // create handler
                $handlerTypeClass = new \ReflectionClass($handlerType);
                $handler = $handlerTypeClass->newInstanceArgs($handlerData["params"]);
                if (isset($handlerData['formatter'])) {
                    $formatterData = $handlerData['formatter'];
                    $formatterType = $formatterData['type'];
                    // create formatter
                    $formatterClass = new \ReflectionClass($formatterType);
                    $formatter = $formatterClass->newInstanceArgs($formatterData['params']);
                    // set formatter to logger
                    $handler->setFormatter($formatter);
                }
                $handlers[] = $handler;
            }

            // get logger type
            $loggerType = $loggerConfig->getType();
            // init logger instance
            $logger = new $loggerType($loggerConfig->getName(), $handlers, $processors);

            $logger->debug(sprintf('logger initialised: %s (%s)', $loggerConfig->getName(), $loggerType));

            // set logger by name
            $loggers[$loggerConfig->getName()] = $logger;
        }

        // init servers
        $servers = array();
        foreach ($mainConfiguration->getServerConfigs() as $serverConfig) {

            // get type definitions
            $serverType = $serverConfig->getType();
            $serverContextType = $serverConfig->getServerContextType();

            // init server context
            $serverContext = new $serverContextType();
            $serverContext->init($serverConfig);

            // check if logger name exists
            if (isset($loggers[$serverConfig->getLoggerName()])) {
                $serverContext->injectLoggers($loggers);
            } else {
                throw new \Exception(sprintf('Logger %s not found.', $serverConfig->getLoggerName()));
            }

            // Create the server (which should start it automatically)
            $server = new $serverType($serverContext);
            // Collect the servers we started
            $servers[] = $server;

            // Synchronize the server so we can wait until preparation of the server finished.
            // This is used e.g. to wait for port opening or other important dependencies to proper server functionality
            $server->synchronized(
                function ($self) {
                    $self->wait();
                },
                $server
            );
        }

        // @TODO here we are able to switch user to someone with lower rights (e.g. www-data or nobody)

        // wait for servers
        foreach ($servers as $server) {
            $server->join();
        }
    }
}
