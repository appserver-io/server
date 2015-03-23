<?php

/**
 * \AppserverIo\Server\Interfaces\StreamContextInterface
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
 * Interface ServerContextInterface
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface StreamContextInterface
{
    
    /**
     * Sets an options to the internal resource context object
     *
     * @param string $wrapper The wrapper section of the option
     * @param string $option  The option key
     * @param mixed  $value   The value to set for option in specific wrapper section
     *
     * @return bool true on success or false on failure
     */
    public function setOption($wrapper, $option, $value);
    
    /**
     * Returns an specific options in certain wrapper section
     *
     * @param unknown $wrapper The wrapper section of the option
     * @param unknown $option  The option key to get the value for
     *
     * @return mixed The options value null if nothing exists
     */
    public function getOption($wrapper, $option);
    
    /**
     * Returns all options set on internal stream context resource
     *
     * @return array all options
     */
    public function getOptions();
    
    /**
     * Adds a server ssl certificate for specific domain using the sni feature
     *
     * @param string $domain    The domain for the certificate to use
     * @param string $certPath  The path to the bundled certificate file
     * @param bool   $overwrite If an existing domain entry should be overwritten or not
     *
     * @return bool true on success or false on failure
     */
    public function addSniServerCert($domain, $certPath, $overwrite = true);
}
