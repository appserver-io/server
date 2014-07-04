<?php
/**
 * \TechDivision\Server\Contexts\ServerContext
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

namespace TechDivision\Server\Contexts;

use Psr\Log\LoggerInterface;
use TechDivision\Server\Dictionaries\EnvVars;
use TechDivision\Server\Exceptions\ConnectionHandlerNotFoundException;
use TechDivision\Server\Exceptions\ModuleNotFoundException;
use TechDivision\Server\Exceptions\ServerException;
use TechDivision\Server\Interfaces\ServerConfigurationInterface;
use TechDivision\Server\Interfaces\ServerContextInterface;
use TechDivision\Server\Sockets\SocketInterface;
use TechDivision\Server\Dictionaries\ServerVars;
use TechDivision\Storage\GenericStackable;

/**
 * Class ServerContext
 *
 * @category  Server
 * @package   TechDivision_Server
 * @author    Johann Zelger <jz@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Server
 */
class ServerContext extends GenericStackable implements ServerContextInterface
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
     * @var LoggerInterface[]
     */
    protected $loggers;

    /**
     * Hold's the config instance
     *
     * @var \TechDivision\Server\Interfaces\ServerConfigurationInterface $serverConfig
     */
    protected $serverConfig;

    /**
     * Initialises the server context
     *
     * @param \TechDivision\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers configuration
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig)
    {
        // set configuration
        $this->serverConfig = $serverConfig;
        // init logger storage as stackable
        $this->loggers = new GenericStackable();
    }

    /**
     * Return's the server config instance
     *
     * @return \TechDivision\Server\Interfaces\ServerConfigurationInterface The server config instance
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
        // iterate loggers to storage
        foreach ($loggers as $loggerName => $loggerInstance) {
            $this->loggers["$loggerName"] = $loggerInstance;
        }
    }

    /**
     * Return's the logger instance
     *
     * @param string $loggerType the logger's type to get
     *
     * @return \Psr\Log\LoggerInterface|null The logger instance
     * @throws \TechDivision\Server\Exceptions\ServerException
     */
    public function getLogger($loggerType = self::DEFAULT_LOGGER_TYPE)
    {
        // check if logger is set
        if (isset($this->loggers[$loggerType])) {
            // return logger
            return $this->loggers[$loggerType];
        }
        // throw exception
        throw new ServerException("Logger name '$loggerType' does not exist.", 500);
    }
}
