<?php

/**
 * \AppserverIo\Server\Configuration\ModuleJsonConfiguration
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

namespace AppserverIo\Server\Configuration;

use AppserverIo\Server\Interfaces\ModuleConfigurationInterface;

/**
 * Implementation for a module configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ModuleJsonConfiguration implements ModuleConfigurationInterface
{

    /**
     * Holds raw data instance
     *
     * @var \stdClass
     */
    protected $data;

    /**
     * The module parameters.
     *
     * @var array
     */
    protected $params = array();

    /**
     * Constructs config
     *
     * @param \stdClass $node The JSON node used to build config
     */
    public function __construct($node)
    {

        // prepare properties
        $this->type = $node->type;
        $this->params = $node->params;
    }

    /**
     * Returns the module's class name.
     *
     * @return string The module's class name
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Array with the module params to use.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns the param with the passed name casted to the specified type.
     *
     * @param string $name The name of the param to be returned
     *
     * @return mixed The requested param casted to the specified type
     */
    public function getParam($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
    }
}
