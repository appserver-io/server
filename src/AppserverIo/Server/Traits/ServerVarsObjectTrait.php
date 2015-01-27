<?php

/**
 * \AppserverIo\Server\Traits\ServerVarsObjectTrait
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
 * Trait ServerVarsObjectTrait
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
trait ServerVarsObjectTrait
{
    /**
     * Sets a value to specific server var
     *
     * @param string $serverVar The server var to set
     * @param string $value     The value to server var
     *
     * @return void
     */
    public function setServerVar($serverVar, $value)
    {
        $this->serverVars->add($serverVar, $value);
    }

    /**
     * Unsets a specific server var
     *
     * @param string $serverVar The server var to unset
     *
     * @return void
     */
    public function unsetServerVar($serverVar)
    {
        $this->serverVars->remove($serverVar);
    }

    /**
     * Returns a value for specific server var
     *
     * @param string $serverVar The server var to get value for
     *
     * @throws \AppserverIo\Server\Exceptions\ServerException
     *
     * @return string The value to given server var
     */
    public function getServerVar($serverVar)
    {
        // get from hash map
        return $this->serverVars->get($serverVar);
    }

    /**
     * Returns all the server vars as array key value pair format
     *
     * @return array The server vars as array
     */
    public function getServerVars()
    {
        return $this->serverVars->toIndexedArray();
    }

    /**
     * Checks if value exists for given server var
     *
     * @param string $serverVar The server var to check
     *
     * @return bool Weather it has serverVar (true) or not (false)
     */
    public function hasServerVar($serverVar)
    {
        // check if server var is set
        return $this->serverVars->exists($serverVar);
    }

    /**
     * Clears the server vars storage
     *
     * @return void
     */
    public function clearServerVars()
    {
        $this->serverVars->clear();
    }
}
