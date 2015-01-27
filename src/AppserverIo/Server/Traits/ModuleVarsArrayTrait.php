<?php

/**
 * \AppserverIo\Server\Traits\ModuleVarsArrayTrait
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

use AppserverIo\Server\Exceptions\ServerException;

/**
 * Trait ModuleVarsArrayTrait
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
trait ModuleVarsArrayTrait
{

    /**
     * Sets a value to specific module var
     *
     * @param string $moduleVar The module var to set
     * @param string $value     The value to module var
     *
     * @return void
     */
    public function setModuleVar($moduleVar, $value)
    {
        if (!is_null($value)) {
            $this->moduleVars[$moduleVar] = $value;
        }
    }

    /**
     * Unsets a specific module var
     *
     * @param string $moduleVar The module var to unset
     *
     * @return void
     */
    public function unsetModuleVar($moduleVar)
    {
        if (isset($this->moduleVars[$moduleVar])) {
            unset($this->moduleVars[$moduleVar]);
        }
    }

    /**
     * Returns a value for specific module var
     *
     * @param string $moduleVar The module var to get value for
     *
     * @throws \AppserverIo\Server\Exceptions\ServerException
     *
     * @return mixed The value to given module var
     */
    public function getModuleVar($moduleVar)
    {
        // check if var is set
        if (isset($this->moduleVars[$moduleVar])) {
            // return vars value
            return $this->moduleVars[$moduleVar];
        }
        // throw exception
        throw new ServerException("Module var '$moduleVar'' does not exist.", 500);
    }


    /**
     * Returns all the module vars as array key value pair format
     *
     * @return array The module vars as array
     */
    public function getModuleVars()
    {
        return $this->moduleVars;
    }

    /**
     * Checks if value exists for given module var
     *
     * @param string $moduleVar The module var to check
     *
     * @return boolean Weather it has moduleVar (true) or not (false)
     */
    public function hasModuleVar($moduleVar)
    {
        // check if var is set
        if (!isset($this->moduleVars[$moduleVar])) {
            return false;
        }

        return true;
    }

    /**
     * Clears the module vars storage
     *
     * @return void
     */
    public function clearModuleVars()
    {
        foreach ($this->moduleVars as $key => $value) {
            unset($this->moduleVars[$key]);
        }
    }
}
