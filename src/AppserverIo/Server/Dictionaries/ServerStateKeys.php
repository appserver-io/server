<?php

/**
 * AppserverIo\Server\Dictionaries\ServerStateKeys
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
 * @subpackage Traits
 * @author     Tim Wagner <tw@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Dictionaries;

use AppserverIo\Server\Exceptions\InvalidServerStateException;

/**
 * Utility class that contains the server state keys.
 *
 * @package    Library
 * @package    Server
 * @subpackage Traits
 * @author     Tim Wagner <tw@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */
class ServerStateKeys
{

    /**
     * Server has to be stopped.
     *
     * @var integer
     */
    const HALT = 0;

    /**
     * Server is waiting for initialization.
     *
     * @var integer
     */
    const WAITING_FOR_INITIALIZATION = 1;

    /**
     * Server has been successfully initialized.
     *
     * @var integer
     */
    const INITIALIZATION_SUCCESSFUL = 2;

    /**
     * Servers socket has been started successful.
     *
     * @var integer
     */
    const SERVER_SOCKET_STARTED = 3;

    /**
     * Servers modules has successfully been initialized.
     *
     * @var integer
     */
    const MODULES_INITIALIZED = 4;

    /**
     * Servers connection handlers has successfully been initialized.
     *
     * @var integer
     */
    const CONNECTION_HANDLERS_INITIALIZED = 5;

    /**
     * Servers workers has successfully been initialized.
     *
     * @var integer
     */
    const WORKERS_INITIALIZED = 6;

    /**
     * The actual server state.
     *
     * @var integer
     */
    private $serverState;

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     *
     * @param integer $serverState The server state to initialize the instance with
     */
    private function __construct($serverState)
    {
        $this->serverState = $serverState;
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Returns the server state representation as integer.
     *
     * @return integer The integer representation of the server state
     */
    public function getServerState()
    {
        return $this->serverState;
    }

    /**
     * Returns the server state representation as string.
     *
     * @return string The string representation of the server state
     * @see \TechDivision\ApplicationServer\Dictionaries\ServerStateKeys::getServerState()
     */
    public function __toString()
    {
        return sprintf('%d', $this->getServerState());
    }

    /**
     * Returns the server states.
     *
     * @return array The server states
     */
    public static function getServerStates()
    {
        return array(
            ServerStateKeys::WAITING_FOR_INITIALIZATION,
            ServerStateKeys::INITIALIZATION_SUCCESSFUL,
            ServerStateKeys::SERVER_SOCKET_STARTED,
            ServerStateKeys::MODULES_INITIALIZED,
            ServerStateKeys::CONNECTION_HANDLERS_INITIALIZED,
            ServerStateKeys::WORKERS_INITIALIZED
        );
    }

    /**
     * Returns TRUE if the server state is greater than the passed one, else FALSE.
     *
     * @param \AppserverIo\Server\Dictionaries\ServerStateKeys $serverState The server state to be greater than
     *
     * @return boolean TRUE if equal, else FALSE
     */
    public function greaterOrEqualThan(ServerStateKeys $serverState)
    {
        return $this->serverState >= $serverState->getServerState();
    }

    /**
     * Returns TRUE if the passed server state equals the actual one, else FALSE.
     *
     * @param \AppserverIo\Server\Dictionaries\ServerStateKeys $serverState The server state to check
     *
     * @return boolean TRUE if equal, else FALSE
     */
    public function equals(ServerStateKeys $serverState)
    {
        return $this->serverState === $serverState->getServerState();
    }

    /**
     * Factory method to create a new server state instance.
     *
     * @param integer $serverState The server state to create an instance for
     *
     * @return \AppserverIo\Server\Dictionaries\ServerStateKeys The server state key instance
     * @throws \AppserverIo\Server\Exceptions\InvalidServerStateException
     *      Is thrown if the server state is not available
     */
    public static function get($serverState)
    {

        // check if the requested server state is available and create a new instance
        if (in_array($serverState, ServerStateKeys::getServerStates())) {
            return new ServerStateKeys($serverState);
        }

        // throw a exception if the requested server state is not available
        throw new InvalidServerStateException(
            sprintf(
                'Requested server state %s is not available (choose on of: %s)',
                $serverState,
                implode(',', ServerStateKeys::getServerStates())
            )
        );
    }
}
