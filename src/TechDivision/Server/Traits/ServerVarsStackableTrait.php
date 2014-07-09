<?php
/**
 * \TechDivision\Server\Traits\ServerVarsStackableTrait
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
 * Trait ServerVarsTrait
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Traits
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
trait ServerVarsStackableTrait
{
    /**
     * Set's a value to specific server var
     *
     * @param string $serverVar The server var to set
     * @param string $value     The value to server var
     *
     * @return void
     */
    public function setServerVar($serverVar, $value)
    {
        if (!is_null($value)) {
            $this["S_$serverVar"] = $value;
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
        if (isset($this["S_$serverVar"])) {
            unset($this["S_$serverVar"]);
        }
    }

    /**
     * Return's a value for specific server var
     *
     * @param string $serverVar The server var to get value for
     *
     * @throws \TechDivision\Server\Exceptions\ServerException
     *
     * @return string The value to given server var
     */
    public function getServerVar($serverVar)
    {
        // check if server var is set
        if (isset($this["S_$serverVar"])) {
            // return server vars value
            return $this["S_$serverVar"];
        }
        // throw exception
        throw new ServerException("Server var '$serverVar'' does not exist.", 500);
    }

    /**
     * Return's all the server vars as array key value pair format
     *
     * @return array The server vars as array
     */
    public function getServerVars()
    {
        return array_filter(
            array_keys((array)$this),
            function ($key) {
                return substr($key, 0, 2) === "S_";
            }
        );
    }

    /**
     * Check's if value exists for given server var
     *
     * @param string $serverVar The server var to check
     *
     * @return bool Weather it has serverVar (true) or not (false)
     */
    public function hasServerVar($serverVar)
    {
        // check if server var is set
        if (!isset($this["S_$serverVar"])) {
            return false;
        }

        return true;
    }

    /**
     * Clear's the server vars storage
     *
     * @return void
     */
    public function clearServerVars()
    {
        foreach ($this->getServerVars() as $serverVar => $serverVarValue) {
            unset($this["S_$serverVar"]);
        }
    }
}
