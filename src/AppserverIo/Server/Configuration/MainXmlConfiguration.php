<?php

/**
 * \AppserverIo\Server\Configuration\MainXmlConfiguration
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

use AppserverIo\Server\Configuration\ServerXmlConfiguration;
use AppserverIo\Server\Configuration\LoggerXmlConfiguration;
use AppserverIo\Server\Configuration\UpstreamXmlConfiguration;

/**
 * Class MainXmlConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class MainXmlConfiguration
{
    /**
     * Hold's the simple xml element read from file
     *
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * Constructs main configuration
     *
     * @param string $filename The filename to load simple xml with
     */
    public function __construct($filename)
    {
        $this->xml = simplexml_load_file($filename);
    }

    /**
     * Return's server config nodes as array
     *
     * @return array
     */
    public function getServerConfigs()
    {
        $serverConfigurations = array();
        if (isset($this->xml->servers)) {
            foreach ($this->xml->servers->server as $serverConfig) {
                $serverConfigurations[] = new ServerXmlConfiguration($serverConfig);
            }
        }
        return $serverConfigurations;
    }

    /**
     * Return's logger config nodes as array
     *
     * @return array
     */
    public function getLoggerConfigs()
    {
        $loggerConfigurations = array();
        if (isset($this->xml->loggers)) {
            foreach ($this->xml->loggers->logger as $loggerConfig) {
                $loggerConfigurations[] = new LoggerXmlConfiguration($loggerConfig);
            }
        }
        return $loggerConfigurations;
    }

    /**
     * Return's upstream config nodes as array
     *
     * @return array
     */
    public function getUpstreamConfigs()
    {
        $upstreamConfigurations = array();
        if (isset($this->xml->upstreams)) {
            foreach ($this->xml->upstreams->upstream as $upstreamConfig) {
                $upstreamConfigurations[] = new UpstreamXmlConfiguration($upstreamConfig);
            }
        }
        return $upstreamConfigurations;
    }
}
