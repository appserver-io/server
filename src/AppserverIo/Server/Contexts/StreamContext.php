<?php

/**
 * \AppserverIo\Server\Contexts\StreamContext
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

namespace AppserverIo\Server\Contexts;

use AppserverIo\Server\Exceptions\ServerException;
use AppserverIo\Server\Interfaces\StreamContextInterface;

class StreamContext implements StreamContextInterface
{
    /**
     * Constructs the stream context object
     *
     * @param array $defaultOptions The default options to instantiate the context with
     */
    public function __construct(array $defaultOptions = array())
    {
        // setup internal php resource
        $this->resource = stream_context_create($defaultOptions);
    }
    
    /**
     * Sets an options to the internal resource context object
     *
     * @param string $wrapper The wrapper section of the option
     * @param string $option  The option key
     * @param mixed  $value   The value to set for option in specific wrapper section
     *
     * @return bool true on success or false on failure
     */
    public function setOption($wrapper, $option, $value)
    {
        return stream_context_set_option($this->getResource(), $wrapper, $option, $value);
    }
    
    /**
     * Returns an specific options in certain wrapper section
     *
     * @param unknown $wrapper The wrapper section of the option
     * @param unknown $option  The option key to get the value for
     *
     * @return mixed The options value null if nothing exists
     */
    public function getOption($wrapper, $option)
    {
        $value = null;
        $options = stream_context_get_options($this->getResource());
        if (isset($options[$wrapper][$option])) {
            $value = $options[$wrapper][$option];
        }
        return $value;
    }
    
    /**
     * Returns all options set on internal stream context resource
     *
     * @return array all options
     */
    public function getOptions()
    {
        return stream_context_get_options($this->getResource());
    }
    
    /**
     * Adds a server ssl certificate for specific domain using the sni feature
     *
     * @param string $domain    The domain for the certificate to use
     * @param string $certPath  The path to the bundled certificate file
     * @param bool   $overwrite If an existing domain entry should be overwritten or not
     *
     * @return bool true on success or false on failure
     */
    public function addSniServerCert($domain, $certPath, $overwrite = true)
    {
        // get existing server certs
        $sniServerCerts = $this->getOption('ssl', 'SNI_server_certs');
        // check if sni server certs are set already or new should be started
        if (!is_array($sniServerCerts)) {
            $sniServerCerts = array();
        }
        
        // check if domain key exists and no overwrite is wanted
        if (isset($sniServerCerts[$domain]) && $overwrite === false) {
            return false;
        }
        
        // check if cert exists
        if (!is_file($certPath)) {
            throw new ServerException(
                sprintf("SSL certificate '%s' does not exist for domain '%s'.", $certPath, $domain)
            );
        }
        
        // check if cert is valid for server usage
        $x509_res = openssl_x509_read(file_get_contents($certPath));
        $valid = openssl_x509_checkpurpose($x509_res, X509_PURPOSE_SSL_SERVER, array($certPath));
        if ($valid === true) {
            // if its valid, add it to sni server certs
            $sniServerCerts[$domain] = $certPath;
        } else {
            throw new ServerException(
                sprintf("SSL certificate '%s' is not valid for domain '%s'.", $certPath, $domain)
            );
        }

        // add it to array
        $sniServerCerts[$domain] = $certPath;
        
        // add sni server certs array back to stream context resource instance
        return $this->setOption('ssl', 'SNI_server_certs', $sniServerCerts);
    }

    /**
     * Returns the internal php stream context resource for php stream usage compatibility
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
