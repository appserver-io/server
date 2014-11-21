<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Appserver
 * @package    Server
 * @subpackage Configuration
 * @author     Bernhard Wick <bw@appserver.io>
 * @copyright  2014 TechDivision GmbH - <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://www.github.com/appserver-io/server
 */

namespace AppserverIo\Server\Configuration\Extension;

/**
 * AppserverIo\Server\Configuration\Extension\AbstractInjector
 *
 * This class allows to inject a configuration based in a database
 *
 * @category   Appserver
 * @package    Server
 * @subpackage Configuration
 * @author     Bernhard Wick <bw@appserver.io>
 * @copyright  2014 TechDivision GmbH - <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://www.github.com/appserver-io/server
 */
abstract class AbstractInjector implements InjectorInterface
{

    /**
     * The PDO database connection object
     *
     * @var \PDO $dbResource
     */
    protected $pdoString;

    /**
     * The PDO database connection object
     *
     * @var \PDO $dbResource
     */
    protected $user;

    /**
     * The PDO database connection object
     *
     * @var \PDO $dbResource
     */
    protected $password;

    /**
     * Default constructor
     *
     * @param string $pdoString The PDO connection string
     * @param string $user      The user used to connect to the DB
     * @param string $password  The needed password
     */
    public function __construct($pdoString, $user = '', $password = '')
    {
        $this->pdoString = $pdoString;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Getter for the database resource
     *
     * @return \PDO
     */
    public function getDbResource()
    {
        return new \PDO($this->pdoString, $this->user, $this->password);
    }
}
