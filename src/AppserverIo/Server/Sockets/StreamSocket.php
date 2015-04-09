<?php

/**
 * \AppserverIo\Server\Sockets\StreamSocket
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

namespace AppserverIo\Server\Sockets;

use AppserverIo\Psr\Socket\SocketInterface;
use AppserverIo\Psr\Socket\SocketReadException;
use AppserverIo\Psr\Socket\SocketReadTimeoutException;
use AppserverIo\Psr\Socket\SocketServerException;
use AppserverIo\Psr\Socket\AppserverIo\Psr\Socket;

/**
 * Class StreamSocket
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class StreamSocket implements SocketInterface
{

    /**
     * Holds the connection resource itself.
     *
     * @var resource
     */
    protected $connectionResource;

    /**
     * Holds the actual resource id
     *
     * @var int
     */
    protected $connectionResourceId;

    /**
     * Holds the peer name of the client who connected
     *
     * @var string
     */
    protected $connectionPeername;

    /**
     * Creates a stream socket server and returns a instance of Stream implementation with server socket in it.
     *
     * @param string   $socket  The address incl. transport the server should be listening to. For example 0.0.0.0:8080
     * @param string   $flags   The flags to be set on server create
     * @param resource $context The context to be set on stream create
     *
     * @return \AppserverIo\Server\Sockets\StreamSocket The Stream instance with a server socket created.
     *
     * @throws \AppserverIo\Psr\Socket\SocketServerException
     */
    public static function getServerInstance($socket, $flags = null, $context = null)
    {
        // init flags if none were given
        if (is_null($flags)) {
            $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;
        }

        // init context if none was given
        if (is_null($context)) {
            // set socket backlog to 1024 for perform many concurrent connections
            $opts = array(
                'socket' => array(
                    'backlog' => 1024,
                )
            );
            // get default stream context for server connection with socket backlog preset
            $context = stream_context_get_default($opts);
        }

        // create stream socket server resource
        $serverResource = stream_socket_server($socket, $errno, $errstr, $flags, $context);
        
        // throw exception if it was not possible to create server socket binding
        if (!$serverResource) {
            throw new SocketServerException($errstr, $errno);
        }

        // set blocking mode
        stream_set_blocking($serverResource, 1);
        // create instance and return it.
        return self::getInstance($serverResource);
    }

    /**
     * Creates a stream socket client and returns a instance of Stream implementation with client socket in it.
     *
     * @param string   $socket  The address incl. transport the server should be listening to. For example 0.0.0.0:8080
     * @param string   $flags   The flags to be set on client create
     * @param resource $context The context to be set on stream create
     *
     * @return \AppserverIo\Server\Sockets\StreamSocket The Stream instance with a client socket created.
     *
     * @throws \AppserverIo\Psr\Socket\SocketServerException
     */
    public static function getClientInstance($socket, $flags = null, $context = null)
    {
        // init flags if none were given
        if (is_null($flags)) {
            $flags = STREAM_CLIENT_CONNECT;
        }

        // init context if none was given
        if (is_null($context)) {
            // create default stream context object
            $context = stream_context_get_default();
        }

        // create a stream socket client resource
        $clientResource = stream_socket_client($socket, $errno, $errstr, ini_get('default_socket_timeout'), $flags, $context);

        // throw exception if it was not possible to create server socket binding
        if (!$clientResource) {
            throw new SocketServerException($errstr, $errno);
        }

        // set blocking mode
        stream_set_blocking($clientResource, 1);
        // create instance and return it
        return self::getInstance($clientResource);
    }

    /**
     * Returns an instance of Stream with preset resource in it.
     *
     * @param resource $connectionResource The resource to use
     *
     * @return \AppserverIo\Server\Sockets\StreamSocket
     */
    public static function getInstance($connectionResource)
    {
        $connection = new self();
        $connection->setConnectionResource($connectionResource);
        return $connection;
    }

    /**
     * Accepts connections from clients and build up a instance of Stream with connection resource in it.
     *
     * @param int $acceptTimeout  The timeout in seconds to wait for accepting connections.
     * @param int $receiveTimeout The timeout in seconds to wait for read a line.
     *
     * @return \AppserverIo\Server\Sockets\StreamSocket|bool The Stream instance with the connection socket
     *                                                           accepted or bool false if timeout or error occurred.
     */
    public function accept($acceptTimeout = 600, $receiveTimeout = 60)
    {
        // init local ref vars
        $peername = null;
        
        $connectionResource = @stream_socket_accept($this->getConnectionResource(), $acceptTimeout, $peername);
        // if timeout or error occurred return false as accept function does
        if ($connectionResource === false) {
            return false;
        }
        // set timeout for read data fom client
        stream_set_timeout($connectionResource, $receiveTimeout);
        $connection = $this->getInstance($connectionResource);
        $connection->setPeername($peername);
        return $connection;
    }

    /**
     * Returns the line read from connection resource
     *
     * @param int $readLength     The max length to read for a line.
     * @param int $receiveTimeout The max time to wait for read the next line
     *
     * @return string
     * @throws \AppserverIo\Psr\Socket\SocketReadTimeoutException
     */
    public function readLine($readLength = 1024, $receiveTimeout = null)
    {
        if ($receiveTimeout) {
            // set timeout for read data fom client
            @stream_set_timeout($this->getConnectionResource(), $receiveTimeout);
        }
        $line = @fgets($this->getConnectionResource(), $readLength);
        // check if timeout occurred
        /*
        if (strlen($line) === 0) {
            throw new SocketReadTimeoutException();
        }
        */
        
        if ($line === false) {
            throw new SocketReadException();
        }
        
        return $line;
    }

    /**
     * Reads the given length from connection resource
     *
     * @param int $readLength     The max length to read for a line.
     * @param int $receiveTimeout The max time to wait for read the next line
     *
     * @return string
     *
     * @throws \AppserverIo\Psr\Socket\SocketReadTimeoutException
     * @throws \AppserverIo\Psr\Socket\SocketReadException
     */
    public function read($readLength = 1024, $receiveTimeout = null)
    {
        if ($receiveTimeout) {
            // set timeout for read data fom client
            @stream_set_timeout($this->getConnectionResource(), $receiveTimeout);
        }
        // read in line from client
        $line = @fread($this->getConnectionResource(), $readLength);
        // check if false is response
        if (false === $line) {
            // throw new socket exception
            throw new SocketReadException();
        }
        // check if timeout occurred
        if (strlen($line) === 0) {
            throw new SocketReadTimeoutException();
        }
        return $line;
    }

    /**
     * Writes the given message to the connection resource.
     *
     * @param string $message The message to write to the connection resource.
     *
     * @return int
     */
    public function write($message)
    {
        return @fwrite($this->getConnectionResource(), $message, strlen($message));
    }

    /**
     * Copies data from a stream
     *
     * @param resource $sourceResource The source stream
     *
     * @return int The total count of bytes copied.
     */
    public function copyStream($sourceResource, $length = null)
    {
        // first try to rewind source resource stream
        @rewind($sourceResource);
        // call function by given param values
        if ($length !== null) {
            return @stream_copy_to_stream($sourceResource, $this->getConnectionResource(), $length);
        }
        return @stream_copy_to_stream($sourceResource, $this->getConnectionResource());
    }

    /**
     * Closes the connection resource
     *
     * @return bool
     */
    public function close()
    {
        // check if resource still exists
        if (is_resource($this->getConnectionResource())) {
            return @fclose($this->getConnectionResource());
        }
        return false;
    }
    
    /**
     * Returns the stream socket's status
     * 
     * @return bool|array The status information as array or false in case of an invalid stream socket resource
     */
    public function getStatus()
    {
        return @socket_get_status($this->getConnectionResource());
    }
    
    /**
     * Returns the meta information of the stream socket
     * 
     * @return bool|array The meta informations of the stream socket
     */
    public function getMetaInfo()
    {
        return @stream_get_meta_data($this->getConnectionResource());
    }

    /**
     * Sets the connection resource
     *
     * @param resource $connectionResource The resource to socket file descriptor
     *
     * @return void
     */
    public function setConnectionResource($connectionResource)
    {
        $this->connectionResourceId = (int)$connectionResource;
        $this->connectionResource = $connectionResource;
    }

    /**
     * Sets the peer name
     *
     * @param string $peername The peername in format ip:port
     *
     * @return void
     */
    public function setPeername($peername)
    {
        $this->connectionPeername = $peername;
    }

    /**
     * Returns the peer name in format ip:port (e.g. 10.20.30.40:57128)
     *
     * @return string
     */
    public function getPeername()
    {
        return $this->connectionPeername;
    }

    /**
     * Returns the address of connection
     *
     * @return string
     */
    public function getAddress()
    {
        return strstr($this->getPeername(), ':', true);
    }

    /**
     * Returns the port of connection
     *
     * @return string
     */
    public function getPort()
    {
        return str_replace(':', '', strstr($this->getPeername(), ':'));
    }

    /**
     * Returns the connection resource
     *
     * @return mixed
     */
    public function getConnectionResource()
    {
        return $this->connectionResource;
    }

    /**
     * Returns connection resource id
     *
     * @return int
     */
    public function getConnectionResourceId()
    {
        return $this->connectionResourceId;
    }

}
