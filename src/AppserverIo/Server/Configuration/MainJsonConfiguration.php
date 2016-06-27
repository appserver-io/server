<?php

/**
 * \AppserverIo\Server\Configuration\MainJsonConfiguration
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

use AppserverIo\Server\Interfaces\LoggerConfigurationInterface;
use AppserverIo\Server\Interfaces\MainConfigurationInterface;
use AppserverIo\Server\Interfaces\ServerConfigurationInterface;
use AppserverIo\Server\Interfaces\UpstreamConfigurationInterface;

/**
 * Class MainJsonConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class MainJsonConfiguration implements MainConfigurationInterface
{
    /**
     * Hold's the data instance read by json file
     *
     * @var \stdClass
     */
    protected $data;

    /**
     * Constructs the config by given filename
     *
     * @param string $filename The filename to init the config with
     */
    public function __construct($filename)
    {
        $this->data = json_decode(file_get_contents($filename, FILE_USE_INCLUDE_PATH));
    }

    /**
     * Return's an array of server configs
     *
     * @return ServerConfigurationInterface[]
     */
    public function getServerConfigs()
    {
        $serverConfigurations = array();
        foreach ($this->data->servers as $serverConfig) {
            $serverConfigurations[] = new ServerJsonConfiguration($serverConfig);
        }

        return $serverConfigurations;
    }

    /**
     * Return's an array of logger configs
     *
     * @return LoggerConfigurationInterface[]
     */
    public function getLoggerConfigs()
    {
        $loggerConfigurations = array();
        foreach ($this->data->loggers as $loggerConfig) {
            $loggerConfigurations[] = new LoggerJsonConfiguration($loggerConfig);
        }

        return $loggerConfigurations;
    }

    /**
     * Return's upstream config nodes as array
     *
     * @return UpstreamConfigurationInterface[]
     */
    public function getUpstreamConfigs()
    {
        $upstreamConfigs = array();
        if (isset($this->data->upstreams)) {
            foreach ($this->data->upstreams as $upstreamConfig) {
                $upstreamConfigs[] = new UpstreamJsonConfiguration($upstreamConfig);
            }
        }

        return $upstreamConfigs;
    }
}
