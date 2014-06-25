<?php
/**
 * \TechDivision\Server\Interfaces\WorkerInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server\Interfaces;

/**
 * Interface WorkerInterface
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Interfaces
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
interface WorkerInterface
{
    /**
     * Return's an array of connection handlers to use
     *
     * @return array
     */
    public function getConnectionHandlers();

    /**
     * Return's the server context instance
     *
     * @return \TechDivision\Server\Interfaces\ServerContextInterface The server's context
     */
    public function getServerContext();

    /**
     * Start's the worker
     *
     * @return void
     */
    public function run();

    /**
     * Implements the workers actual logic
     *
     * @return void
     */
    public function work();

    /**
     * Prepares the worker's in it's own context for upcoming work to do on things
     * that can not be shared by using the init method in the parent's context.
     *
     * @return void
     */
    public function prepare();

    /**
     * Does shutdown logic for worker if something breaks in process.
     *
     * This shutdown function will be called from specific connection handler if an error occurs, so the connection
     * handler can send an response in the correct protocol specifications and a new worker can be started
     *
     * @return void
     */
    public function shutdown();
}
