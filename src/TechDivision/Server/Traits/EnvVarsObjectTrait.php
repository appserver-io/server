<?php
/**
 * \TechDivision\Server\Traits\EnvVarsObjectTrait
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

/**
 * Trait EnvVarsObjectTrait
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Traits
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
trait EnvVarsObjectTrait
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
        $this->envVars->add($envVar, $value);
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
        $this->envVars->remove($envVar);
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
        // get from hash map
        return $this->envVars->get($envVar);
    }

    /**
     * Return's all the env vars as array key value pair format
     *
     * @return array The env vars as array
     */
    public function getEnvVars()
    {
        return $this->envVars->toIndexedArray();
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
        return $this->envVars->exists($envVar);
    }

    /**
     * Clear's the env vars storage
     *
     * @return void
     */
    public function clearEnvVars()
    {
        $this->envVars->clear();
    }
}
