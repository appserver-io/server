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
     * Return's flags
     *
     * @return string
     */
    public function getFlags();

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
     * Returns template path for possible configured auto index page
     *
     * @return string
     */
    public function getAutoIndexTemplatePath();

    /**
     * Returns server context type
     *
     * @return string
     */
    public function getServerContextType();

    /**
     * Returns stream context type
     *
     * @return string
     */
    public function getStreamContextType();

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
     * Returns the headers definition used by the server
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Returns the certificates used by the server
     *
     * @return array
     */
    public function getCertificates();

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

    /**
     * Returns the auto index configuration.
     *
     * @return boolean
     */
    public function getAutoIndex();

    /**
     * Return's DH param path
     *
     * @return string
     */
    public function getDhParamPath();

    /**
     * Return's private key path
     *
     * @return string
     */
    public function getPrivateKeyPath();

    /**
     * Return's the crypto method to use
     *
     * @return string
     */
    public function getCryptoMethod();

    /**
     * Return's the peer name to be used, if this value is not set, then the name is guessed based on the hostname used when opening the stream
     *
     * @return string
     */
    public function getPeerName();

    /**
     * Return's TRUE it the verification of use SSL certificate has to be required
     *
     * @return boolean
     */
    public function getVerifyPeer();

    /**
     * Return's TRUE it the peer name has to be verified
     *
     * @return boolean
     */
    public function getVerifyPeerName();

    /**
     * Return's TRUE to disable TLS compression. This can help mitigate the CRIME attack vector
     *
     * @return boolean
     */
    public function getDisableCompression();

    /**
     * Return's TRUE if self-signed certificates has to be allowed, but requires verify_peer to be FALSE
     *
     * @return boolean
     */
    public function getAllowSelfSigned();

    /**
     * Return's TRUE if control cipher ordering preferences during negotiation has to be allowed
     *
     * @return boolean
     */
    public function getHonorCipherOrder();

    /**
     * Return's the curve to use with ECDH ciphers, if not specified prime256v1 will be used
     *
     * @return string
     */
    public function getEcdhCurve();

    /**
     * Return's TRUE if a new key pair has to be created in scenarios where ECDH cipher suites are negotiated (instead of the preferred ECDHE ciphers)
     *
     * @return boolean
     */
    public function getSingleEcdhUse();

    /**
     * Return's TRUE if new key pair has to be created created when using DH parameters (improves forward secrecy)
     *
     * @return boolean
     */
    public function getSingleDhUse();
}
