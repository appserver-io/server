<?php
/**
 * \TechDivision\Server\Traits\ModuleVarsStackableTrait
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
 * Trait ModuleVarsStackableTrait
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Traits
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
trait ModuleVarsStackableTrait
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
            $this["M_$moduleVar"] = $value;
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
        if (isset($this["M_$moduleVar"])) {
            unset($this["M_$moduleVar"]);
        }
    }

    /**
     * Return's a value for specific module var
     *
     * @param string $moduleVar The module var to get value for
     *
     * @throws \TechDivision\Server\Exceptions\ServerException
     *
     * @return mixed The value to given module var
     */
    public function getModuleVar($moduleVar)
    {
        // check if var is set
        if (isset($this["M_$moduleVar"])) {
            // return vars value
            return $this["M_$moduleVar"];
        }
        // throw exception
        throw new ServerException("Module var '$moduleVar'' does not exist.", 500);
    }


    /**
     * Return's all the module vars as array key value pair format
     *
     * @return array The module vars as array
     */
    public function getModuleVars()
    {
        return array_filter(
            array_keys((array)$this),
            function ($key) {
                return substr($key, 0, 2) === "M_";
            }
        );
    }

    /**
     * Check's if value exists for given module var
     *
     * @param string $moduleVar The module var to check
     *
     * @return boolean Weather it has moduleVar (true) or not (false)
     */
    public function hasModuleVar($moduleVar)
    {
        // check if var is set
        if (!isset($this["M_$moduleVar"])) {
            return false;
        }

        return true;
    }

    /**
     * Clear's the module vars storage
     *
     * @return void
     */
    public function clearModuleVars()
    {
        foreach ($this->getModuleVars() as $moduleVar => $moduleVarValue) {
            unset($this["M_$moduleVar"]);
        }
    }
}
