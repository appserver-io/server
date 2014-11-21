<?php

/**
 * \AppserverIo\Server\Interfaces\ServerInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @package    Library
 * @package    Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Interfaces;

/**
 * Interface ServerInterface
 *
 * @package    Library
 * @package    Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */
interface ServerInterface
{

    /**
     * Return's the server config instance
     *
     * @return \AppserverIo\Server\Interfaces\ServerContextInterface
     */
    public function getServerContext();

    /**
     * Start's the server's worker as defined in configuration
     *
     * @return void
     */
    public function run();
}
