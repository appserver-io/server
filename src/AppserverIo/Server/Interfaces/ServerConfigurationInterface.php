<?php

/**
 * \AppserverIo\Server\Interfaces\ServerConfigurationInterface
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

namespace AppserverIo\Server\Interfaces;

/**
 * Interface ServerConfigurationInterface
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface ServerConfigurationInterface
{
    /**
     * Returns name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns type
     *
     * @return string
     */
    public function getType();

    /**
     * Returns transport
     *
     * @return string
     */
    public function getTransport();

    /**
     * Returns address
     *
     * @return string
     */
    public function getAddress();

    /**
     * Returns port
     *
     * @return int
     */
    public function getPort();

    /**
     * Returns logger name
     *
     * @return string
     */
    public function getLoggerName();

    /**
     * Returns workerNumber
     *
     * @return int
     */
    public function getWorkerNumber();

    /**
     * Returns worker accept min count
     *
     * @return int
     */
    public function getWorkerAcceptMin();

    /**
     * Returns worker accept max count
     *
     * @return int
     */
    public function getWorkerAcceptMax();

    /**
     * Returns software
     *
     * @return string
     */
    public function getSoftware();

    /**
     * Returns admin
     *
     * @return string
     */
    public function getAdmin();

    /**
     * Returns keep-alive max connection
     *
     * @return int
     */
    public function getKeepAliveMax();

    /**
     * Returns keep-alive timeout
     *
     * @return int
     */
    public function getKeepAliveTimeout();

    /**
     * Returns template path for errors page
     *
     * @return string
     */
    public function getErrorsPageTemplatePath();

    /**
     * Returns template path for possible configured welcome page
     *
     * @return string
     */
    public function getWelcomePageTemplatePath();

    /**
     * Returns server context type
     *
     * @return string
     */
    public function getServerContextType();

    /**
     * Returns request context type
     *
     * @return string
     */
    public function getRequestContextType();

    /**
     * Returns socket type
     *
     * @return string
     */
    public function getSocketType();

    /**
     * Returns worker type
     *
     * @return string
     */
    public function getWorkerType();

    /**
     * Returns document root
     *
     * @return string
     */
    public function getDocumentRoot();

    /**
     * Returns directory index definition
     *
     * @return string
     */
    public function getDirectoryIndex();

    /**
     * Returns modules
     *
     * @return array
     */
    public function getModules();

    /**
     * Returns connection handlers
     *
     * @return array
     */
    public function getConnectionHandlers();

    /**
     * Returns the virtual hosts
     *
     * @return array
     */
    public function getVirtualHosts();

    /**
     * Returns the authentications
     *
     * @return array
     */
    public function getAuthentications();

    /**
     * Returns handlers
     *
     * @return array
     */
    public function getHandlers();

    /**
     * Returns certPath
     *
     * @return string
     */
    public function getCertPath();

    /**
     * Returns passphrase
     *
     * @return string
     */
    public function getPassphrase();

    /**
     * Returns the rewrite configuration.
     *
     * @return array
     */
    public function getRewrites();

    /**
     * Returns the access configuration.
     *
     * @return array
     */
    public function getAccesses();

    /**
     * Returns the environment variable configuration
     *
     * @return array
     */
    public function getEnvironmentVariables();

    /**
     * Returns the rewrite maps.
     *
     * @return array
     */
    public function getRewriteMaps();

    /**
     * Returns the locations.
     *
     * @return array
     */
    public function getLocations();
}
