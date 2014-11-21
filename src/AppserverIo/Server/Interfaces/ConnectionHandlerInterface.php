<?php

/**
 * \AppserverIo\Server\Interfaces\ConnectionHandlerInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Library
 * @package    Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Interfaces;

use AppserverIo\Server\Sockets\SocketInterface;

/**
 * Class ConnectionHandlerInterface
 *
 * @category   Library
 * @package    Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */
interface ConnectionHandlerInterface
{

    /**
     * Inits the connection handler by given context and params
     *
     * @param \AppserverIo\Server\Interfaces\ServerContextInterface $serverContext The server's context
     * @param array                                                  $params        The params for connection handler
     *
     * @return void
     */
    public function init(ServerContextInterface $serverContext, array $params = null);

    /**
     * Handles the connection with the connected client in a proper way the given
     * protocol type and version expects for example.
     *
     * @param \AppserverIo\Server\Sockets\SocketInterface    $connection The connection to handle
     * @param \AppserverIo\Server\Interfaces\WorkerInterface $worker     The worker how started this handle
     *
     * @return bool Weather it was responsible to handle the firstLine or not.
     */
    public function handle(SocketInterface $connection, WorkerInterface $worker);

    /**
     * Shutdown the connection with the connected client and the response handling in a proper way before
     * an unwanted shutdown happens by either a php fatal error or exit/die was going on.
     *
     * IMPORTANT: Be sure that you are calling the workers shutdown within your shutdown function. This
     * is needed because the worker has to flag itselfe to be restartet from the worker context.
     *
     * @return void
     */
    public function shutdown();
}
