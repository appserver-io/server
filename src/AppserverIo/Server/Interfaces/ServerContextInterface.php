<?php

/**
 * \AppserverIo\Server\Interfaces\ServerContextInterface
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

namespace AppserverIo\Server\Interfaces;

/**
 * Interface ServerContextInterface
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface ServerContextInterface
{
    /**
     * Defines the default logger type
     *
     * @var string
     */
    const DEFAULT_LOGGER_TYPE = 'System';

    /**
     * Initialises the server context
     *
     * @param \AppserverIo\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers configuration instance
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig);

    /**
     * Injects the stream context object for the server socket to be bound with.
     * 
     * @param resource $streamContext
     * 
     * @return void
     */
    public function injectStreamContext($streamContext);

    /**
     * Injects a third party container
     *
     * @param mixed $container The container to inject
     *
     * @return mixed
     */
    public function injectContainer($container);

    /**
     * Injects a Psr compatible logger instance
     *
     * @param array<\Psr\Log\LoggerInterface> $loggers The array of logger instances
     *
     * @return void
     */
    public function injectLoggers(array $loggers);

    /**
     * Return's the server config instance
     *
     * @return \AppserverIo\Server\Interfaces\ServerConfigurationInterface The server config instance
     */
    public function getServerConfig();

    /**
     * Queries if the requested logger type is registered or not.
     *
     * @param string $loggerType The logger type we want to query
     *
     * @return boolean TRUE if the logger is registered, else FALSE
     */
    public function hasLogger($loggerType);

    /**
     * Return's the logger instance
     *
     * @param string $loggerType the logger's type to get
     *
     * @return \Psr\Log\LoggerInterface|null The logger instance
     * @throws \AppserverIo\Server\Exceptions\ServerException
     */
    public function getLogger($loggerType = self::DEFAULT_LOGGER_TYPE);
}
