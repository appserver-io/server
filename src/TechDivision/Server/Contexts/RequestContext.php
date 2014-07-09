<?php
/**
 * \TechDivision\Server\Contexts\RequestContext
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
 * @subpackage Contexts
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */

namespace TechDivision\Server\Contexts;

use TechDivision\Server\Dictionaries\EnvVars;
use TechDivision\Server\Dictionaries\ModuleVars;
use TechDivision\Server\Dictionaries\ServerVars;
use TechDivision\Server\Exceptions\ServerException;
use TechDivision\Server\Interfaces\RequestContextInterface;
use TechDivision\Server\Interfaces\ServerContextInterface;
use TechDivision\Server\Traits\EnvVarsObjectTrait;
use TechDivision\Server\Traits\EnvVarsStackableTrait;
use TechDivision\Server\Traits\EnvVarsArrayTrait;
use TechDivision\Server\Traits\ModuleVarsObjectTrait;
use TechDivision\Server\Traits\ModuleVarsStackableTrait;
use TechDivision\Server\Traits\ModuleVarsArrayTrait;
use TechDivision\Server\Traits\ServerVarsObjectTrait;
use TechDivision\Server\Traits\ServerVarsStackableTrait;
use TechDivision\Server\Traits\ServerVarsArrayTrait;
use TechDivision\Collections\HashMap;
use TechDivision\Storage\GenericStackable;

/**
 * Class ServerContext
 *
 * @category   Server
 * @package    TechDivision_Server
 * @subpackage Contexts
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Server
 */
class RequestContext implements RequestContextInterface
{
    // use traits for server-, env- and module var functionality
    use ServerVarsObjectTrait, ModuleVarsObjectTrait, EnvVarsObjectTrait;
    // use ServerVarsStackableTrait, ModuleVarsStackableTrait, EnvVarsStackableTrait;
    // use ServerVarsArrayTrait, ModuleVarsArrayTrait, EnvVarsArrayTrait;

    /**
     * Defines the handler to use as default
     *
     * @var string
     */
    const REQUEST_HANDLER_DEFAULT = 'core';

    /**
     * Hold's the server context instance
     *
     * @var \TechDivision\Server\Interfaces\ServerContextInterface
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
        $this->serverVars = new HashMap();
        $this->envVars = new HashMap();
        $this->moduleVars = new HashMap();

        // you can use stackable trait when doing this to be synchronised with these hashtables
        // $this->serverVars = new GenericStackable();
        // $this->envVars = new GenericStackable();
        // $this->moduleVars = new GenericStackable();

        // or you just use normal internal arrays
        // $this->serverVars = array();
        // $this->envVars = array();
        // $this->moduleVars = array();
    }

    /**
     * Initialises the request context by given server context
     *
     * @param \TechDivision\Server\Interfaces\ServerContextInterface $serverContext The servers context instance
     *
     * @return void
     */
    public function init(ServerContextInterface $serverContext)
    {
        // set server context ref
        $this->serverContext = $serverContext;
        // init all vars
        $this->initVars();
    }

    /**
     * Return's the server context instance
     *
     * @return \TechDivision\Server\Interfaces\ServerContextInterface
     */
    public function getServerContext()
    {
        return $this->serverContext;
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
        $this->setEnvVar(EnvVars::LOGGER_SYSTEM, $this->getServerContext()->getServerConfig()->getLoggerName());
    }

    /**
     * init's server vars
     *
     * @return void
     */
    public function initServerVars()
    {
        // get local refs
        $serverContext = $this->getServerContext();

        // clear server var storage
        $this->clearServerVars();

        // set server vars to local var to shorter usage
        $serverSoftware = $serverContext->getServerConfig()->getSoftware() . ' (PHP ' . PHP_VERSION . ')';
        $serverAddress = $serverContext->getServerConfig()->getAddress();
        $serverPort = $serverContext->getServerConfig()->getPort();

        // set document root
        $documentRoot = $serverContext->getServerConfig()->getDocumentRoot();

        // check if relative path is given and make is absolute by using getcwd() as prefix
        if (!preg_match("/^([a-zA-Z]:|\/)/", $documentRoot)) {
            $documentRoot = getcwd() . DIRECTORY_SEPARATOR . $documentRoot;
        }

        // build initial server vars
        $this->setServerVar(ServerVars::DOCUMENT_ROOT, $documentRoot);
        $this->setServerVar(ServerVars::SERVER_ADMIN, $serverContext->getServerConfig()->getAdmin());
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
        $this->setServerVar(ServerVars::SERVER_ERRORS_PAGE_TEMPLATE_PATH, $serverContext->getServerConfig()->getErrorsPageTemplatePath());
        $this->setServerVar(ServerVars::PATH, getenv('PATH'));
        $this->setServerVar(ServerVars::HTTPS, ServerVars::VALUE_HTTPS_OFF);

        // check if ssl is going on and set server var for it like apache does
        if ($serverContext->getServerConfig()->getTransport() === 'ssl') {
            $this->setServerVar(ServerVars::HTTPS, ServerVars::VALUE_HTTPS_ON);
        }
    }

    /**
     * Return's the logger instance
     *
     * @param string $loggerType the logger's type to get
     *
     * @return \Psr\Log\LoggerInterface|null The logger instance
     * @throws \TechDivision\Server\Exceptions\ServerException
     */
    public function getLogger($loggerType = self::DEFAULT_LOGGER_TYPE)
    {
        // check if there is information about this logger type in env vars
        if ($this->hasEnvVar($loggerType)) {
            // get logger name from module vars by key
            $loggerName = $this->getEnvVar($loggerType);
            // get specific logger from system context
            return $this->getServerContext()->getLogger($loggerName);
        }
        // log error to system logger
        $this->getServerContext()->getLogger()->debug(
            sprintf("No logger type '$loggerType' found in env vars.")
        );
    }
}
