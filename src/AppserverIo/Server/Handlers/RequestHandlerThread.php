<?php

/**
 * \AppserverIo\Server\Handlers\RequestHandlerThread
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
 * @subpackage Handlers
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Handlers;

use AppserverIo\Server\Interfaces\ServerContextInterface;
use AppserverIo\Server\Interfaces\WorkerInterface;

/**
 * This class is just for testing purpose, so please don't use it for this moment.
 *
 * @category   Library
 * @package    Server
 * @subpackage Handlers
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */
class RequestHandlerThread extends \Thread
{
    /**
     * Constructs the request handler thread and start's it
     *
     * @param resource                                              $connectionResource The connection resource
     * @param array                                                 $connectionHandlers An array of connection handlers
     * @param \AppserverIo\Server\Interfaces\ServerContextInterface $serverContext      The server's context
     * @param \AppserverIo\Server\Interfaces\WorkerInterface        $worker             The worker instance
     */
    public function __construct(
        $connectionResource,
        array $connectionHandlers,
        ServerContextInterface $serverContext,
        WorkerInterface $worker
    ) {
        $this->connectionResource = $connectionResource;
        $this->connectionHandlers = $connectionHandlers;
        $this->serverContext = $serverContext;
        $this->worker = $worker;
        $this->start();
    }

    /**
     * Runs workload
     *
     * @return void
     */
    public function run()
    {
        // setup environment for handler
        require SERVER_AUTOLOADER;

        // set local var refs
        $serverContext = $this->serverContext;
        $connectionHandlers = $this->connectionHandlers;
        $worker = $this->worker;

        // get socket type
        $socketType = $serverContext->getServerConfig()->getSocketType();

        // get connection instance by resource
        $connection = $socketType::getInstance($this->connectionResource);

        // iterate all connection handlers to handle connection right
        foreach ($connectionHandlers as $connectionHandler) {
            // if connectionHandler handled connection than break out of foreach
            if ($connectionHandler->handle($connection, $worker)) {
                break;
            }
        }
    }
}
