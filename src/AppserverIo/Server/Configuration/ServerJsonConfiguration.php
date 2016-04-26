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
     * Returns flags
     *
     * @return string
     */
    public function getFlags()
    {
        return $this->data->flags;
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
     * Returns template path for possible configured welcome page
     *
     * @return string
     */
    public function getWelcomePageTemplatePath()
    {
        return $this->data->welcomePageTemplatePath;
    }

    /**
     * Returns template path for possible configured auto index page
     *
     * @return string
     */
    public function getAutoIndexTemplatePath()
    {
        return $this->data->autoIndexTemplatePath;
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
     * Returns the auto index configuration
     *
     * @return boolean
     */
    public function getAutoIndex()
    {
        return (boolean)$this->data->autoIndex;
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
     * Returns stream context type
     *
     * @return string
     */
    public function getStreamContextType()
    {
        return $this->data->streamContext;
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
     * Returns the headers used by the server
     *
     * @return array
     */
    public function getHeaders()
    {
        if (!$this->headers) {
            $this->headers = $this->prepareHeaders($this->data);
        }
        return $this->headers;
    }

    /**
     * Returns the certificates used by the server
     *
     * @return array
     */
    public function getCertificates()
    {
        if (!$this->certificates) {
            $this->certificates = $this->prepareCertificates($this->data);
        }
        return $this->certificates;
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
            foreach ($data->modules as $module) {
                $modules[] = new ModuleJsonConfiguration($module);
            }
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
     * Prepares the headers array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareHeaders(\stdClass $data)
    {
        $headers = array();
        if (isset($data->headers)) {
            $headers = $data->headers;
        }
        return $headers;
    }

    /**
     * Prepares the certificates array based on a data object
     *
     * @param \stdClass $data The data object
     *
     * @return array
     */
    public function prepareCertificates(\stdClass $data)
    {
        $certificates = array();
        if (isset($data->certificates)) {
            $certificates = $data->certificates;
        }
        return $certificates;
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

    /**
     * Return's DH param path
     *
     * @return string
     */
    public function getDhParamPath()
    {
        return $this->data->dhParamPath;
    }

    /**
     * Return's private key path
     *
     * @return string
     */
    public function getPrivateKeyPath()
    {
        return $this->data->privateKeyPath;
    }

    /**
     * Return's the crypto method to use
     *
     * @return string
     */
    public function getCryptoMethod()
    {
        return $this->data->cryptoMethod;
    }

    /**
     * Return's the peer name to be used, if this value is not set, then the name is guessed based on the hostname used when opening the stream
     *
     * @return string
     */
    public function getPeerName()
    {
        return $this->data->peerName;
    }

    /**
     * Return's TRUE it the verification of use SSL certificate has to be required
     *
     * @return boolean
     */
    public function getVerifyPeer()
    {
        return (boolean)$this->data->verifyPeer;
    }

    /**
     * Return's TRUE it the peer name has to be verified
     *
     * @return boolean
     */
    public function getVerifyPeerName()
    {
        return (boolean)$this->data->verifyPeerName;
    }

    /**
     * Return's TRUE to disable TLS compression. This can help mitigate the CRIME attack vector
     *
     * @return boolean
     */
    public function getDisableCompression()
    {
        return (boolean)$this->data->disableCompression;
    }

    /**
     * Return's TRUE if self-signed certificates has to be allowed, but requires verify_peer to be FALSE
     *
     * @return boolean
     */
    public function getAllowSelfSigned()
    {
        return (boolean)$this->data->allowSelfSigned;
    }

    /**
     * Return's TRUE if control cipher ordering preferences during negotiation has to be allowed
     *
     * @return boolean
     */
    public function getHonorCipherOrder()
    {
        return (boolean)$this->data->honorCipherOrder;
    }

    /**
     * Return's the curve to use with ECDH ciphers, if not specified prime256v1 will be used
     *
     * @return string
     */
    public function getEcdhCurve()
    {
        return $this->data->ecdhCurve;
    }

    /**
     * Return's TRUE if a new key pair has to be created in scenarios where ECDH cipher suites are negotiated (instead of the preferred ECDHE ciphers)
     *
     * @return boolean
     */
    public function getSingleEcdhUse()
    {
        return (boolean)$this->data->singleEcdhUse;
    }

    /**
     * Return's TRUE if new key pair has to be created created when using DH parameters (improves forward secrecy)
     *
     * @return boolean
     */
    public function getSingleDhUse()
    {
        return (boolean)$this->data->singleDhUse;
    }

    /**
     * Return's the list of available ciphers.
     *
     * @return string
     * @link http://php.net/manual/en/context.ssl.php#context.ssl.ciphers
     * @link https://www.openssl.org/docs/manmaster/apps/ciphers.html#CIPHER_LIST_FORMAT
     */
    public function getCiphers()
    {
        return $this->data->ciphers;
    }
}
