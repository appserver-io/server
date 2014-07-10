<?php
/**
 * \TechDivision\Server\Traits\EnvVarsArrayTrait
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
 * @subpackage Traits
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server\Traits;

use TechDivision\Server\Exceptions\ServerException;

/**
 * Trait EnvVarsArrayTrait
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Traits
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
trait EnvVarsArrayTrait
{
    /**
     * Sets a value to specific env var
     *
     * @param string $envVar The env var to set
     * @param string $value  The value to env var
     *
     * @return void
     */
    public function setEnvVar($envVar, $value)
    {
        if (!is_null($value)) {
            $this->envVars[$envVar] = $value;
        }
    }

    /**
     * Unsets a specific env var
     *
     * @param string $envVar The env var to unset
     *
     * @return void
     */
    public function unsetEnvVar($envVar)
    {
        if (isset($this->envVars[$envVar])) {
            unset($this->envVars[$envVar]);
        }
    }

    /**
     * Return's a value for specific env var
     *
     * @param string $envVar The env var to get value for
     *
     * @throws \TechDivision\Server\Exceptions\ServerException
     *
     * @return mixed The value to given env var
     */
    public function getEnvVar($envVar)
    {
        // check if var is set
        if (isset($this->envVars[$envVar])) {
            // return vars value
            return $this->envVars[$envVar];
        }
        // throw exception
        throw new ServerException("Env var '$envVar'' does not exist.", 500);
    }

    /**
     * Return's all the env vars as array key value pair format
     *
     * @return array The env vars as array
     */
    public function getEnvVars()
    {
        return $this->envVars;
    }

    /**
     * Check's if value exists for given env var
     *
     * @param string $envVar The env var to check
     *
     * @return boolean Weather it has envVar (true) or not (false)
     */
    public function hasEnvVar($envVar)
    {
        // check if var is set
        if (!isset($this->envVars[$envVar])) {
            return false;
        }

        return true;
    }

    /**
     * Clear's the env vars storage
     *
     * @return void
     */
    public function clearEnvVars()
    {
        foreach ($this->envVars as $key => $value) {
            unset($this->envVars[$key]);
        }
    }
}
