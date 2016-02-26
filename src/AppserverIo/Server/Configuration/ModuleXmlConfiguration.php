<?php

/**
 * \AppserverIo\Server\Configuration\ModuleXmlConfiguration
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
use AppserverIo\Server\Utils\ServerUtil;

/**
 * Implementation for a module configuration.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ModuleXmlConfiguration implements ModuleConfigurationInterface
{

    /**
     * The module's class name.
     *
     * @var string
     */
    protected $type;

    /**
     * The module parameters.
     *
     * @var array
     */
    protected $params = array();

    /**
     * Constructs config
     *
     * @param \SimpleXMLElement $node The simple xml element used to build config
     */
    public function __construct($node)
    {

        // prepare properties
        $this->type = (string) $node->attributes()->type;
        $this->params = $this->prepareParams($node);
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

    /**
     * Prepares the modules array based on a simple xml element node
     *
     * @param \SimpleXMLElement $node The xml node
     *
     * @return array
     */
    protected function prepareParams(\SimpleXMLElement $node)
    {

        // initialize the parameters
        $params = array();

        // query whether or not parameters have been specified
        if ($node->params) {
            // append the passed parameters
            foreach ($node->params->param as $param) {
                $params[(string) $param->attributes()->name] = ServerUtil::singleton()->castToType((string) $param->attributes()->type, (string) $param);
            }
        }

        // return the initialized parameters
        return $params;
    }
}
