<?php

/**
 * \AppserverIo\Server\Configuration\ServerJsonConfiguration
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

use AppserverIo\Server\Interfaces\ServerConfigurationInterface;

/**
 * Class ServerJsonConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ServerJsonConfiguration implements ServerConfigurationInterface
{
    /**
     * Holds raw data instance
     *
     * @var \stdClass
     */
    protected $data;

    /**
     * Holds the modules to be used
     *
     * @var array
     */
    protected $modules;

    /**
     * Holds the handlers array
     *
     * @var array
     */
    protected $handlers;

    /**
     * Holds the virtual hosts array
     *
     * @var array
     */
    protected $virtualHosts;

    /**
     * Holds the authentications array
     *
     * @var array
     */
    protected $authentications;

    /**
     * Holds the rewrites array
     *
     * @var array
     */
    protected $rewrites;

    /**
     * Holds the environmentVariables array
     *
     * @var array
     */
    protected $environmentVariables;

    /**
     * Holds the connection handlers array
     *
     * @var array
     */
    protected $connectionHandlers;

    /**
     * Holds the accesses array
     *
     * @var array
     */
    protected $accesses;

    /**
     * Holds the accesses array
     *
     * @var array
     */
    protected $analytics;
    
    /**
     * The configured locations.
     *
     * @var array
     */
    protected $locations;

    /**
     * The rewrite maps
     *
     * @var array
     */
    protected $rewriteMaps;

    /**
     * Constructs config
     *
     * @param \stdClass $data The data object use
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->data->name;
    }

    /**
     * Returns logger name
     *
     * @return string
     */
    public function getLoggerName()
    {
        return $this->data->loggerName;
    }

    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->data->type;
    }

    /**
     * Returns transport
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->data->transport;
    }

    /**
     * Returns address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->data->address;
    }

    /**
     * Returns port
     *
     * @return int
     */
    public function getPort()
    {
        return (int)$this->data->port;
    }

    /**
     * Returns software
     *
     * @return string
     */
    public function getSoftware()
    {
        return $this->data->software;
    }

    /**
     * Returns admin
     *
     * @return string
     */
    public function getAdmin()
    {
        return $this->data->admin;
    }

    /**
     * Returns keep-alive max connection
     *
     * @return int
     */
    public function getKeepAliveMax()
    {
        return (int)$this->data->keepAliveMax;
    }

    /**
     * Returns keep-alive timeout
     *
     * @return int
     */
    public function getKeepAliveTimeout()
    {
        return (int)$this->data->keepAliveTimeout;
    }

    /**
     * Returns admin
     *
     * @return string
     */
    public function getErrorsPageTemplatePath()
    {
        return $this->data->errorsPageTemplatePath;
    }

    /**
     * Returns worker number
     *
     * @return int
     */
    public function getWorkerNumber()
    {
        return (int)$this->data->workerNumber;
    }

    /**
     * Returns worker's accept min count
     *
     * @return int
     */
    public function getWorkerAcceptMin()
    {
        return (int)$this->data->workerAcceptMin;
    }

    /**
     * Returns worker's accept min count
     *
     * @return int
     */
    public function getWorkerAcceptMax()
    {
        return (int)$this->data->workerAcceptMax;
    }

    /**
     * Returns context type
     *
     * @return string
     */
    public function getServerContextType()
    {
        return $this->data->serverContext;
    }

    /**
     * Returns request type
     *
     * @return string
     */
    public function getRequestContextType()
    {
        return $this->data->requestContext;
    }

    /**
     * Returns socket type
     *
     * @return string
     */
    public function getSocketType()
    {
        return $this->data->socket;
    }

    /**
     * Returns worker type
     *
     * @return string
     */
    public function getWorkerType()
    {
        return $this->data->worker;
    }

    /**
     * Returns document root
     *
     * @return string
     */
    public function getDocumentRoot()
    {
        return $this->data->documentRoot;
    }

    /**
     * Returns directory index definition
     *
     * @return string
     */
    public function getDirectoryIndex()
    {
        return $this->data->directoryIndex;
    }

    /**
     * Returns connection handlers
     *
     * @return array
     */
    public function getConnectionHandlers()
    {
        if (!$this->connectionHandlers) {
            $this->connectionHandlers = $this->prepareConnectionHandlers($this->data);
        }
        return $this->connectionHandlers;
    }

    /**
     * Returns the virtual hosts
     *
     * @return array
     */
    public function getVirtualHosts()
    {
        if (!$this->virtualHosts) {
            $this->virtualHosts = $this->prepareVirtualHosts($this->data);
        }
        return $this->virtualHosts;
    }

    /**
     * Returns the authentications
     *
     * @return array
     */
    public function getAuthentications()
    {
        if (!$this->authentications) {
            $this->authentications = $this->prepareAuthentications($this->data);
        }
        return $this->authentications;
    }

    /**
     * Returns modules
     *
     * @return array
     */
    public function getModules()
    {
        if (!$this->modules) {
            $this->modules = $this->prepareModules($this->data);
        }
        return $this->modules;
    }

    /**
     * Returns handlers
     *
     * @return array
     */
    public function getHandlers()
    {
        if (!$this->handlers) {
            $this->handlers = $this->prepareHandlers($this->data);
        }
        return $this->handlers;
    }

    /**
     * Returns cert path
     *
     * @return string
     */
    public function getCertPath()
    {
        return $this->data->certPath;
    }

    /**
     * Returns passphrase
     *
     * @return string
     */
    public function getPassphrase()
    {
        return $this->data->passphrase;
    }

    /**
     * Returns the rewrite configuration.
     *
     * @return array
     */
    public function getRewrites()
    {
        // init rewrites
        if (!$this->rewrites) {
            $this->rewrites = $this->prepareRewrites($this->data);
        }
        // return the rewrites
        return $this->rewrites;
    }

    /**
     * Returns the environment variable configuration
     *
     * @return array
     */
    public function getEnvironmentVariables()
    {
        // init EnvironmentVariables
        if (!$this->environmentVariables) {
            $this->environmentVariables = $this->prepareEnvironmentVariables($this->data);
        }
        // return the environmentVariables
        return $this->environmentVariables;
    }

    /**
     * Returns the accesses
     *
     * @return array
     */
    public function getAccesses()
    {
        if (!$this->accesses) {
            $this->accesses = $this->prepareAccesses($this->data);
        }
        return $this->accesses;
    }

    /**
     * Returns the analytics
     *
     * @return array
     */
    public function getAnalytics()
    {
        if (!$this->analytics) {
            $this->analytics = $this->prepareAnalytics($this->data);
        }
        return $this->analytics;
    }
    
    /**
     * Returns the locations.
     *
     * @return array
     */
    public function getLocations()
    {
        if (!$this->locations) {
            $this->locations = $this->prepareLocations($this->data);
        }
        return $this->locations;
    }


    /**
     * Returns the rewrite maps.
     *
     * @return array
     */
    public function getRewriteMaps()
    {
        if (!$this->rewriteMaps) {
            $this->rewriteMaps = $this->prepareRewriteMaps($this->data);
        }
        return $this->rewriteMaps;
    }

    /**
     * Prepares the modules array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareModules(\stdClass $data)
    {
        $modules = array();
        if (isset($data->modules)) {
            $modules = $data->modules;
        }
        return $modules;
    }

    /**
     * Prepares the connectionHandlers array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareConnectionHandlers(\stdClass $data)
    {
        $connectionHandlers = array();
        if (isset($data->connectionHandlers)) {
            $connectionHandlers = $data->connectionHandlers;
        }
        return $connectionHandlers;
    }

    /**
     * Prepares the handlers array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareHandlers(\stdClass $data)
    {
        $handlers = array();
        if (isset($data->handlers)) {
            foreach ($data->handlers as $handler) {
                // get all params
                $params = array();
                if (isset($handler->params)) {
                    $params = (array)$handler->params;
                }
                // set the handler information
                $handlers[$handler->extension] = array(
                    "name" => $handler->name,
                    "params" => $params
                );
            }
        }
        return $handlers;
    }

    /**
     * Prepares the virtual hosts array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareVirtualHosts(\stdClass $data)
    {
        $virtualHosts = array();
        if (isset($data->virtualHosts)) {
            foreach ($data->virtualHosts as $virtualHost) {
                // explode virtuaHost names
                $virtualHostNames = explode(' ', $virtualHost->name);
                // get all params
                $params = get_object_vars($virtualHost);
                // remove name
                unset($params["name"]);
                // set all virtual host information's
                foreach ($virtualHostNames as $virtualHostName) {
                    // add all virtual hosts params per key for faster matching later on
                    $virtualHosts[trim($virtualHostName)] = array(
                        'params' => $params,
                        'rewriteMaps' => $this->prepareRewriteMaps($virtualHost),
                        'rewrites' => $this->prepareRewrites($virtualHost),
                        'locations' => $this->prepareLocations($virtualHost),
                        'environmentVariables' => $this->prepareEnvironmentVariables($virtualHost),
                        'authentication' => $this->prepareAuthentications($virtualHost),
                        'accesses' => $this->prepareAccesses($virtualHost),
                        'analytics' => $this->prepareAnalytics($virtualHost)
                    );
                }
            }
        }
        return $virtualHosts;
    }

    /**
     * Prepares the rewrites array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareRewrites(\stdClass $data)
    {
        $rewrites = array();
        if (isset($data->rewrites)) {
            // prepare the array with the rewrite rules
            foreach ($data->rewrites as $rewrite) {
                // Build up the array entry
                $rewrites[] = array(
                    'condition' => $rewrite->condition,
                    'target' => $rewrite->target,
                    'flag' => $rewrite->flag
                );
            }
        }
        return $rewrites;
    }

    /**
     * Prepares the environmentVariables array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareEnvironmentVariables(\stdClass $data)
    {
        $environmentVariables = array();
        if (isset($data->environmentVariables)) {
            // prepare the array with the environment variables
            foreach ($data->environmentVariables as $environmentVariable) {
                // Build up the array entry
                $environmentVariables[] = array(
                    'condition' => $environmentVariable->condition,
                    'definition' => $environmentVariable->definition
                );
            }
        }
        return $environmentVariables;
    }

    /**
     * Prepares the authentications array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareAuthentications(\stdClass $data)
    {
        $authentications = array();
        if (isset($data->authentications)) {
            foreach ($data->authentications as $authentication) {
                $authenticationType = $authentication->uri;
                // get all params
                $params = get_object_vars($authentication);
                // remove type
                unset($params["uri"]);
                // set all authentication information's
                $authentications[$authenticationType] = $params;
            }
        }
        return $authentications;
    }

    /**
     * Prepares the access array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareAccesses(\stdClass $data)
    {
        $accesses = array();
        if (isset($data->accesses)) {
            foreach ($data->accesses as $access) {
                $accessType = $access->type;
                // get all params
                $params = get_object_vars($access);
                // remove type
                unset($params["type"]);
                // set all accesses information's
                $accesses[$accessType][] = $params;
            }
        }
        return $accesses;
    }

    /**
     * Prepares the analytics array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareAnalytics(\stdClass $data)
    {
        $analytics = array();
        if (isset($data->analytics)) {
            foreach ($data->analytics as $analytic) {
                $connectors = array();
                foreach ($analytic->connectors as $connector) {
                    // get all params
                    $params = get_object_vars($connector->params);
                    // build up the connectors entry
                    $connectors[] = array(
                        'name' => $connector->name,
                        'type' => $connector->type,
                        'params' => $params
                    );
                }

                // build up the analytics entry
                $analytics[] = array(
                    'uri' => $analytic->uri,
                    'connectors' => $connectors
                );
            }
        }
        return $analytics;
    }

    /**
     * Prepares the locations array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareLocations(\stdClass $data)
    {
        $locations = array();
        if (isset($data->locations)) {
            // prepare the array with the location variables
            foreach ($data->locations as $location) {
                // Build up the array entry
                $locations[] = array(
                    'condition' => $location->condition,
                    'handlers' => $this->prepareHandlers($location)
                );
            }
        }
        return $locations;
    }

    /**
     * Prepares the rewrite maps array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareRewriteMaps(\stdClass $data)
    {
        $rewriteMaps = array();
        if (isset($data->rewriteMaps)) {
            // prepare the array with the rewrite maps variables
            foreach ($data->rewriteMaps as $rewriteMap) {
                // Build up the array entry
                $rewriteMaps[$rewriteMap->type] = array(
                    'params' => (array)$rewriteMap->params
                );
            }
        }
        return $rewriteMaps;
    }
}
