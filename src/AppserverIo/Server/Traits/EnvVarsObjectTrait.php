<?php

/**
 * \AppserverIo\Server\Traits\EnvVarsObjectTrait
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

namespace AppserverIo\Server\Traits;

/**
 * Trait EnvVarsObjectTrait
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
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
     * Returns a value for specific env var
     *
     * @param string $envVar The env var to get value for
     *
     * @throws \AppserverIo\Server\Exceptions\ServerException
     *
     * @return mixed The value to given env var
     */
    public function getEnvVar($envVar)
    {
        // get from hash map
        return $this->envVars->get($envVar);
    }

    /**
     * Returns all the env vars as array key value pair format
     *
     * @return array The env vars as array
     */
    public function getEnvVars()
    {
        return $this->envVars->toIndexedArray();
    }

    /**
     * Checks if value exists for given env var
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
     * Clears the env vars storage
     *
     * @return void
     */
    public function clearEnvVars()
    {
        $this->envVars->clear();
    }
}
