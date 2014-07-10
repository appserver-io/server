<?php
/**
 * \TechDivision\Server\Interfaces\RequestContextInterface
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
 * Interface RequestContextInterface
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
interface RequestContextInterface
{
    /**
     * Initialises the request context by given server config
     *
     * @param \TechDivision\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers config
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig);

    /**
     * Set's a value to specific server var
     *
     * @param string $serverVar The server var to set
     * @param string $value     The value to server var
     *
     * @return void
     */
    public function setServerVar($serverVar, $value);

    /**
     * Return's a value for specific server var
     *
     * @param string $serverVar The server var to get value for
     *
     * @return string The value to given server var
     */
    public function getServerVar($serverVar);

    /**
     * Check's if value exists for given server var
     *
     * @param string $serverVar The server var to check
     *
     * @return bool Weather it has serverVar (true) or not (false)
     */
    public function hasServerVar($serverVar);

    /**
     * Return's all the server vars as array key value pair format
     *
     * @return array The server vars as array
     */
    public function getServerVars();

    /**
     * Clear's the server vars storage
     *
     * @return void
     */
    public function clearServerVars();

    /**
     * Set's a value to specific module var
     *
     * @param string $moduleVar The module var to set
     * @param string $value     The value to module var
     *
     * @return void
     */
    public function setModuleVar($moduleVar, $value);

    /**
     * Return's a value for specific module var
     *
     * @param string $moduleVar The module var to get value for
     *
     * @return mixed The value to given module var
     * @throws \TechDivision\Server\Exceptions\ServerException
     */
    public function getModuleVar($moduleVar);

    /**
     * Return's all the module vars as array key value pair format
     *
     * @return array The module vars as array
     */
    public function getModuleVars();

    /**
     * Check's if value exists for given module var
     *
     * @param string $moduleVar The module var to check
     *
     * @return boolean Weather it has moduleVar (true) or not (false)
     */
    public function hasModuleVar($moduleVar);

    /**
     * Clear's the module vars storage
     *
     * @return void
     */
    public function clearModuleVars();

    /**
     * Sets a value to specific env var
     *
     * @param string $envVar The env var to set
     * @param string $value  The value to env var
     *
     * @return void
     */
    public function setEnvVar($envVar, $value);

    /**
     * Unsets a specific env var
     *
     * @param string $envVar The env var to unset
     *
     * @return void
     */
    public function unsetEnvVar($envVar);

    /**
     * Return's a value for specific env var
     *
     * @param string $envVar The env var to get value for
     *
     * @return mixed The value to given env var
     * @throws \TechDivision\Server\Exceptions\ServerException
     */
    public function getEnvVar($envVar);

    /**
     * Return's all the env vars as array key value pair format
     *
     * @return array The env vars as array
     */
    public function getEnvVars();

    /**
     * Check's if value exists for given env var
     *
     * @param string $envVar The env var to check
     *
     * @return boolean Weather it has envVar (true) or not (false)
     */
    public function hasEnvVar($envVar);

    /**
     * Clear's the env vars storage
     *
     * @return void
     */
    public function clearEnvVars();

    /**
     * Resets all var used in server context
     *
     * @return void
     */
    public function initVars();
}
