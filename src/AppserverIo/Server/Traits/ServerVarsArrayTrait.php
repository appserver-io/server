<?php

/**
 * \AppserverIo\Server\Traits\ServerVarsArrayTrait
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

use AppserverIo\Server\Dictionaries\ServerVars;
use AppserverIo\Server\Exceptions\ServerException;

/**
 * Trait ServerVarsArrayTrait
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
trait ServerVarsArrayTrait
{

    /**
     * Maps configuration value types to string values.
     *
     * @var array
     */
    protected $typeMappings = array(
        ServerVars::SERVER_AUTO_INDEX => array(
            true  => ServerVars::VALUE_AUTO_INDEX_ON,
            false => ServerVars::VALUE_AUTO_INDEX_OFF
        ),
        ServerVars::HTTPS => array(
            'ssl' => ServerVars::VALUE_HTTPS_ON,
            'tcp' => ServerVars::VALUE_HTTPS_OFF
        )
    );

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
        if (!is_null($value)) {
            if (isset($this->typeMappings[$serverVar][$value])) {
                $this->serverVars[$serverVar] = $this->typeMappings[$serverVar][$value];
            } else {
                $this->serverVars[$serverVar] = $value;
            }
        }
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
        if (isset($this->serverVars[$serverVar])) {
            unset($this->serverVars[$serverVar]);
        }
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
        // check if server var is set
        if (isset($this->serverVars[$serverVar])) {
            return $this->serverVars[$serverVar];
        }
        // throw exception
        throw new ServerException("Server var '$serverVar'' does not exist.", 500);
    }

    /**
     * Returns all the server vars as array key value pair format.
     *
     * @return array The server vars as array
     */
    public function getServerVars()
    {
        return $this->serverVars;
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
        if (!isset($this->serverVars[$serverVar])) {
            return false;
        }

        return true;
    }

    /**
     * Clears the server vars storage
     *
     * @return void
     */
    public function clearServerVars()
    {
        foreach (array_keys($this->serverVars) as $key) {
            unset($this->serverVars[$key]);
        }
    }
}
