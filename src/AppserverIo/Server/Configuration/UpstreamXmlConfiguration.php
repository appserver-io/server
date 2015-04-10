<?php

/**
 * \AppserverIo\Server\Configuration\UpstreamXmlConfiguration
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

namespace AppserverIo\Server\Configuration;

use AppserverIo\Server\Interfaces\UpstreamConfigurationInterface;

/**
 * Class UpstreamXmlConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class UpstreamXmlConfiguration extends UpstreamConfigurationInterface
{
    /**
     * Holds the name of the upstream node
     * 
     * @var string
     */
    public $name;
    
    /**
     * Holds the type of the upstream node
     * 
     * @var string
     */
    public $type;
    
    /**
     * Holds the servers for the upstream node
     * 
     * @var array
     */
    public $servers;
    
    /**
     * Constructs config
     *
     * @param \SimpleXMLElement $node The simple xml element used to build config
     */
    public function __construct(\SimpleXMLElement $node)
    {
        // prepare properties
        $this->name = (string)$node->attributes()->name;
        $this->type = (string)$node->attributes()->type;
        
        if (isset($node->attributes()->channel)) {
            $this->channel = (string)$node->attributes()->channel;
        }
    
        // prepare handlers
        $this->servers = $this->prepareServers($node);
    }
    
    /**
     * Prepares server nodes configured for upstream
     *
     * @param \SimpleXMLElement $node
     */
    protected function prepareServers(\SimpleXMLElement $node)
    {
        $servers = array();
        foreach ($node->servers->server as $serverNode) {
            $name = (string)$serverNode->attributes()->name;
            $type = (string)$serverNode->attributes()->type;
            $params = array();
            foreach ($serverNode->params->param as $paramNode) {
                $paramName = (string)$paramNode->attributes()->name;
                $paramType = (string)$paramNode->attributes()->type;
                $paramValue = (string)$paramNode;
                // check if type boolen and transform true and false strings to int
                if ($paramType === 'boolean') {
                    $paramValue = str_replace(array('true', 'false', '1', '0'), array(1,0,1,0 ), $paramValue);
                }
                // set correct value type
                settype($paramValue, $paramType);
                $params[$paramName] = $paramValue;
            }
            $servers[$name] = array(
                'name' => $name,
                'type' => $type,
                'params' => $params
            );
        }
        return $servers;
    }
    
    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns servers
     * 
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }

}