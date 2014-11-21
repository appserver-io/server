<?php

/**
 * \AppserverIo\Server\Contexts\ServerContext
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   Server
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2014 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Contexts;

use Psr\Log\LoggerInterface;
use AppserverIo\Server\Dictionaries\EnvVars;
use AppserverIo\Server\Exceptions\ConnectionHandlerNotFoundException;
use AppserverIo\Server\Exceptions\ModuleNotFoundException;
use AppserverIo\Server\Exceptions\ServerException;
use AppserverIo\Server\Interfaces\ServerConfigurationInterface;
use AppserverIo\Server\Interfaces\ServerContextInterface;
use AppserverIo\Server\Sockets\SocketInterface;
use AppserverIo\Server\Dictionaries\ServerVars;

/**
 * Class ServerContext
 *
 * @category  Library
 * @package   Server
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2014 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 */
class ServerContext implements ServerContextInterface
{
    /**
     * Optionally hold's an container implementation of third party environment.
     * So every mod depending on his environment can use this as a container to transfer environment specific stuff.
     *
     * @var mixed
     */
    protected $container;

    /**
     * All logger instances will be hold here.
     * Every logger instance has to be a PSR compatible
     *
     * @var array
     */
    protected $loggers;

    /**
     * Hold's the config instance
     *
     * @var \AppserverIo\Server\Interfaces\ServerConfigurationInterface $serverConfig
     */
    protected $serverConfig;

    /**
     * Initialises the server context
     *
     * @param \AppserverIo\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers configuration
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig)
    {
        // set configuration
        $this->serverConfig = $serverConfig;
        // init logger storage as stackable
        $this->loggers = array();
    }

    /**
     * Return's the server config instance
     *
     * @return \AppserverIo\Server\Interfaces\ServerConfigurationInterface The server config instance
     */
    public function getServerConfig()
    {
        return $this->serverConfig;
    }

    /**
     * Injects the container for further use in specific server mods etc...
     *
     * @param mixed $container An container instance for third party environment
     *
     * @return void
     */
    public function injectContainer($container)
    {
        $this->container = $container;
    }

    /**
     * Return's the container instance
     *
     * @return mixed The container instance for third party environment
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Injects a Psr compatible logger instance
     *
     * @param array<\Psr\Log\LoggerInterface> $loggers The array of logger instances
     *
     * @return void
     */
    public function injectLoggers(array $loggers)
    {
        // iterate loggers to collection hashmap
        foreach ($loggers as $loggerName => $loggerInstance) {
            $this->loggers[$loggerName] = $loggerInstance;
        }
    }

    /**
     * Queries if the requested logger type is registered or not.
     *
     * @param string $loggerType The logger type we want to query
     *
     * @return boolean TRUE if the logger is registered, else FALSE
     */
    public function hasLogger($loggerType)
    {
        return isset($this->loggers[$loggerType]);
    }

    /**
     * Return's the logger instance
     *
     * @param string $loggerType the logger's type to get
     *
     * @return \Psr\Log\LoggerInterface|null The logger instance
     * @throws \AppserverIo\Server\Exceptions\ServerException
     */
    public function getLogger($loggerType = self::DEFAULT_LOGGER_TYPE)
    {
        // check if logger is set
        if ($this->hasLogger($loggerType)) {
            // return logger
            return $this->loggers[$loggerType];
        }
        // throw exception
        throw new ServerException("Logger name '$loggerType' does not exist.", 500);
    }
}
