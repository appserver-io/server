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
 * @author    Michael Doehler <michaeldoehler@me.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Configuration;

use AppserverIo\Server\Interfaces\UpstreamConfigurationInterface;

/**
 * Class UpstreamXmlConfiguration
 *
 * @author    Michael Doehler <michaeldoehler@me.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class UpstreamJsonConfiguration implements UpstreamConfigurationInterface
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
     * Holds the channel of the upstream node
     *
     * @var string
     */
    public $channel;

    /**
     * Holds the servers for the upstream node
     *
     * @var array
     */
    public $servers;

    /**
     * Constructs config
     *
     * @param \stdClass $node The JSON node used to build config
     */
    public function __construct($node)
    {
        // prepare properties
        $this->name = (string)$node->name;
        $this->type = (string)$node->type;

        if (isset($node->channel)) {
            $this->channel = (string)$node->channel;
        }

        // prepare servers
        $this->servers = $this->prepareServers($node);
    }

    /**
     * Prepares server nodes configured for upstream
     *
     * @param \stdClass $node The JSON node for servers to prepare
     *
     * @return array
     */
    protected function prepareServers($node)
    {
        $servers = array();
        foreach ($node->servers->server as $serverNode) {
            $name = (string)$serverNode->name;
            $type = (string)$serverNode->type;
            $params = array();
            foreach ($serverNode->params->param as $paramNode) {
                $paramName = (string)$paramNode->name;
                $paramType = (string)$paramNode->type;
                $paramValue = (string)$paramNode;
                // check if type boolen and transform true and false strings to int
                if ($paramType === 'boolean') {
                    $paramValue = str_replace(array('true', 'false', '1', '0'), array(1, 0, 1, 0), $paramValue);
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