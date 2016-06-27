<?php

/**
 * \AppserverIo\Server\Interfaces\MainConfigurationInterface
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

namespace AppserverIo\Server\Interfaces;

/**
 * Interface MainConfigurationInterface
 *
 * @author    Michael Doehler <michaeldoehler@me.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface MainConfigurationInterface
{

    /**
     * Constructs the config by given filename
     *
     * @param string $filename The filename to init the config with
     */
    public function __construct($filename);

    /**
     * Return's server config nodes as array
     *
     * @return ServerConfigurationInterface[]
     */
    public function getServerConfigs();

    /**
     * Return's logger config nodes as array
     *
     * @return LoggerConfigurationInterface[]
     */
    public function getLoggerConfigs();

    /**
     * Return's upstream config nodes as array
     *
     * @return UpstreamConfigurationInterface[]
     */
    public function getUpstreamConfigs();
}
