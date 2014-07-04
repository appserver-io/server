<?php
/**
 * \TechDivision\Server\Interfaces\ServerContextInterface
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
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server\Interfaces;

use Psr\Log\LoggerInterface;
use TechDivision\Server\Interfaces\ServerConfigurationInterface;
use TechDivision\Server\Dictionaries\EnvVars;
use TechDivision\Server\Sockets\SocketInterface;

/**
 * Interface ServerContextInterface
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
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
     * @param \TechDivision\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers configuration instance
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig);

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
     * @return \TechDivision\Server\Interfaces\ServerConfigurationInterface The server config instance
     */
    public function getServerConfig();

    /**
     * Return's the logger instance
     *
     * @param string $loggerType the logger's type to get
     *
     * @return \Psr\Log\LoggerInterface|null The logger instance
     * @throws \TechDivision\Server\Exceptions\ServerException
     */
    public function getLogger($loggerType = self::DEFAULT_LOGGER_TYPE);
}
