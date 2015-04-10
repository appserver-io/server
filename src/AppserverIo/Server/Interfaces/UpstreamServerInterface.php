<?php

/**
 * \AppserverIo\Server\Interfaces\UpstreamServerInterface
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
 * @link      https://github.com/appserver-io/webserver
 * @link      http://www.appserver.io/
 */

namespace AppserverIo\Server\Interfaces;

/**
 * Interface for certain upstream server types
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/webserver
 * @link      http://www.appserver.io/
 */
interface UpstreamServerInterface
{
    /**
     * Returns the address
     *
     * @return string
     */
    public function getAddress();
    
    /**
     * Returns the port
     *
     * @return string
     */
    public function getPort();

    /**
     * Returns the weight
     *
     * @return int
     */
    public function getWeight();

    /**
     * Returns the max fails
     *
     * @return int
     */
    public function getMaxFails();

    /**
     * Returns the fail timeout
     *
     * @return int
     */
    public function getFailTimeout();

    /**
     * Returns the backup flag
     *
     * @return bool
     */
    public function isBackup();

    /**
     * Returns the down flag
     *
     * @return bool
     */
    public function isDown();

    /**
     * Returns the max conns
     *
     * @return int
     */
    public function getMaxConns();

    /**
     * Returns the resolve flag
     *
     * @return bool
     */
    public function shouldResolve();
}
