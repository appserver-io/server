<?php

/**
 * \AppserverIo\Server\Contexts\RequestContext
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

namespace AppserverIo\Server\Contexts;

use AppserverIo\Server\Dictionaries\EnvVars;
use AppserverIo\Server\Dictionaries\ServerVars;
use AppserverIo\Server\Interfaces\RequestContextInterface;
use AppserverIo\Server\Interfaces\ServerConfigurationInterface;
use AppserverIo\Server\Traits\EnvVarsArrayTrait;
use AppserverIo\Server\Traits\ModuleVarsArrayTrait;
use AppserverIo\Server\Traits\ServerVarsArrayTrait;

/**
 * Class ServerContext
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class RequestContext implements RequestContextInterface
{
    // use traits for server-, env- and module var functionality
    use ServerVarsArrayTrait, ModuleVarsArrayTrait, EnvVarsArrayTrait;

    /**
     * Defines the handler to use as default
     *
     * @var string
     */
    const REQUEST_HANDLER_DEFAULT = 'core';

    /**
     * Hold's the server context instance
     *
     * @var \AppserverIo\Server\Interfaces\ServerContextInterface
     */
    protected $serverContext;

    /**
     * This member will hold the server variables which different modules can set/get in order to change the processing
     * of the incoming request.
     * This will also contain server variables as one might suspect in $_SERVER
     *
     * @var array $serverVars
     */
    protected $serverVars;

    /**
     * This member will hold the module variables which different modules can set/get to communicate with each
     * other without knowing each other.
     *
     * @var array $moduleVars
     */
    protected $moduleVars;

    /**
     * This member will hold the environment (env) variables which different modules can set/get to provide
     * the context similar to $_ENV in the plain php world
     *
     * @var array $envVars
     */
    protected $envVars;

    /**
     * Constructs the request context
     */
    public function __construct()
    {
        // init data holders as hash map objects ... user objects traits for that
        // $this->serverVars = new HashMap();
        // $this->envVars = new HashMap();
        // $this->moduleVars = new HashMap();

        // you can use stackable trait when doing this to be synchronised with these hashtables
        // $this->serverVars = new \Stackable();
        // $this->envVars = new \Stackable();
        // $this->moduleVars = new \Stackable();

        // or you just use normal internal arrays
        $this->serverVars = array();
        $this->envVars = array();
        $this->moduleVars = array();
    }

    /**
     * Initialises the request context by given server config
     *
     * @param \AppserverIo\Server\Interfaces\ServerConfigurationInterface $serverConfig The servers config
     *
     * @return void
     */
    public function init(ServerConfigurationInterface $serverConfig)
    {
        // set server context ref
        $this->serverConfig = $serverConfig;
        // init all vars
        $this->initVars();
    }

    /**
     * Return's the server config instance
     *
     * @return \AppserverIo\Server\Interfaces\ServerConfigurationInterface
     */
    public function getServerConfig()
    {
        return $this->serverConfig;
    }

    /**
     * Resets all var used in server context
     *
     * @return void
     */
    public function initVars()
    {
        $this->initServerVars();
        $this->initModuleVars();
        $this->initEnvVars();
    }

    /**
     * init's module vars
     *
     * @return void
     */
    public function initModuleVars()
    {
        // init module vars
        $this->clearModuleVars();
    }

    /**
     * init's env vars
     *
     * @return void
     */
    public function initEnvVars()
    {
        // init env vars array
        $this->clearEnvVars();
        $this->setEnvVar(EnvVars::LOGGER_SYSTEM, $this->getServerConfig()->getLoggerName());
    }

    /**
     * init's server vars
     *
     * @return void
     */
    public function initServerVars()
    {
        // get local refs
        $serverConfig = $this->getServerConfig();

        // clear server var storage
        $this->clearServerVars();

        // set server vars to local var to shorter usage
        $serverSoftware = $serverConfig->getSoftware() . ' (PHP ' . PHP_VERSION . ')';
        $serverAddress = $serverConfig->getAddress();
        $serverPort = $serverConfig->getPort();

        // set document root
        $documentRoot = $serverConfig->getDocumentRoot();

        // check if relative path is given and make is absolute by using getcwd() as prefix
        if (!preg_match("/^([a-zA-Z]:|\/)/", $documentRoot)) {
            $documentRoot = getcwd() . DIRECTORY_SEPARATOR . $documentRoot;
        }

        // build initial server vars
        $this->setServerVar(ServerVars::DOCUMENT_ROOT, $documentRoot);
        $this->setServerVar(ServerVars::SERVER_ADMIN, $serverConfig->getAdmin());
        $this->setServerVar(ServerVars::SERVER_NAME, $serverAddress);
        $this->setServerVar(ServerVars::SERVER_ADDR, $serverAddress);
        $this->setServerVar(ServerVars::SERVER_PORT, $serverPort);
        $this->setServerVar(ServerVars::GATEWAY_INTERFACE, "PHP/" . PHP_VERSION);
        $this->setServerVar(ServerVars::SERVER_SOFTWARE, $serverSoftware);
        $this->setServerVar(
            ServerVars::SERVER_SIGNATURE,
            "<address>$serverSoftware Server at $serverAddress Port $serverPort</address>\r\n"
        );
        $this->setServerVar(ServerVars::SERVER_HANDLER, RequestContext::REQUEST_HANDLER_DEFAULT);
        $this->setServerVar(ServerVars::SERVER_ERRORS_PAGE_TEMPLATE_PATH, $serverConfig->getErrorsPageTemplatePath());
        $this->setServerVar(ServerVars::PATH, getenv('PATH'));
        $this->setServerVar(ServerVars::HTTPS, ServerVars::VALUE_HTTPS_OFF);

        // check if ssl is going on and set server var for it like apache does
        if ($serverConfig->getTransport() === 'ssl') {
            $this->setServerVar(ServerVars::HTTPS, ServerVars::VALUE_HTTPS_ON);
        }
    }
}
