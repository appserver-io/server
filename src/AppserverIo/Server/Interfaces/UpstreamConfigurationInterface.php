<?php

/**
 * \AppserverIo\Server\Interfaces\UpstreamConfigurationInterface
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
 * Interface UpstreamConfigurationInterface
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class UpstreamConfigurationInterface
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
     * Returns servers
     * 
     * @return array
     */
    public function getServers();
}
