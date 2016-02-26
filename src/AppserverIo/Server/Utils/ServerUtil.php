<?php

/**
 * \AppserverIo\Server\Utils\ServerUtil
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Utils;

/**
 * Utility implementation that provides some useful functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ServerUtil
{

    /**
     * Contains possible string to boolean mappings.
     *
     * @var array
     */
    protected $booleanValues = array();

    /**
     * The singleton instance.
     *
     * @var \AppserverIo\Server\Utils\ServerUtil
     */
    protected static $singleton;

    /**
     * Initializes the utility instance.
     */
    protected function __construct()
    {

        // initialize the string to boolean mappings
        $this->booleanValues = array(
            true => true,
            false => false,
            1 => true,
            0 => false,
            "1" => true,
            "0" => false,
            "true" => true,
            "false" => false,
            "on" => true,
            "off" => false,
            "yes" => true,
            "no" => false,
            "y" => true,
            "n" => false
        );
    }

    /**
     * Create's and return's the singleton instance.
     *
     * @return \AppserverIo\Server\Utils\ServerUtil The singleton instance
     */
    public static function singleton()
    {

        // query whether or not the instance already exists
        if (ServerUtil::$singleton == null) {
            ServerUtil::$singleton = new ServerUtil();
        }

        // return the singleton instance
        return ServerUtil::$singleton;
    }

    /**
     * Cast's the passed scalar value to the passed type.
     *
     * @param string $type  The type the value has been casted to
     * @param string $value The value to cast
     *
     * @return mixed The casted value
     * @throws \Exception Is thrown if the passed value can't be casted
     */
    public function castToType($type, $value)
    {

        // query whether or not, the passed value is a scalar type
        if (is_scalar($value) === false) {
            throw new \Exception('Passed value is not of scalar type');
        }

        // query the parameters type
        switch ($type) {
            case 'bool':
            case 'boolean':
                if (isset($this->booleanValues[$value])) {
                    $value = $this->booleanValues[$value];
                } else {
                    throw new \Exception(sprintf('Can\'t cast %s to boolean', $value));
                }
                break;

            default:
                // all other can go the same way
                if (settype($value, $type) === false) {
                    throw new \Exception(sprintf('Can\'t cast %s to %s', $value, type));
                }
        }

        // return the casted value
        return $value;
    }
}
