<?php

/**
 * \AppserverIo\Server\Traits\ModuleVarsObjectTrait
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
 * Trait ModuleVarsObjectTrait
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
trait ModuleVarsObjectTrait
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
        $this->moduleVars->add($moduleVar, $value);
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
        $this->moduleVars->remove($moduleVar);
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
        // get from hash map
        return $this->moduleVars->get($moduleVar);
    }


    /**
     * Returns all the module vars as array key value pair format
     *
     * @return array The module vars as array
     */
    public function getModuleVars()
    {
        return $this->moduleVars->toIndexedArray();
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
        return $this->moduleVars->exists($moduleVar);
    }

    /**
     * Clears the module vars storage
     *
     * @return void
     */
    public function clearModuleVars()
    {
        $this->moduleVars->clear();
    }
}
