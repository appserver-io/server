<?php

/**
 * \AppserverIo\Server\Dictionaries\ModuleHooks
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
 * @subpackage Dictionaries
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */

namespace AppserverIo\Server\Dictionaries;

/**
 * Class ModuleHooks
 *
 * @package    Library
 * @package    Server
 * @subpackage Dictionaries
 * @author     Johann Zelger <jz@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/appserver-io/server
 */
class ModuleHooks
{
    /**
     * The request pre hook should be used to do something before the request will be parsed.
     * So if there is a keep-alive loop going on this will be triggered every request loop.
     *
     * @var int
     */
    const REQUEST_PRE = 1;

    /**
     * The request post hook should be used to do something after the request has been parsed.
     * Most modules such as CoreModule will use this hook to do their job.
     *
     * @var int
     */
    const REQUEST_POST = 2;

    /**
     * The response pre hook will be triggered at the point before the response will be prepared
     * for sending it to the to the connection endpoint.
     *
     * @var int
     */
    const RESPONSE_PRE = 3;

    /**
     * The response post hook is the last hook triggered within a keep-alive loop and will execute
     * the modules logic when the response is well prepared and ready to dispatch
     *
     * @var int
     */
    const RESPONSE_POST = 4;

    /**
     * The shutdown hook is called whenever a php fatal error will shutdown the current worker process.
     * In this case current filehandler module will be called to process the shutdown hook. This enables
     * the module the possibility to react on fatal error's by it's own in some cases. If it does not react
     * on this shutdown hook, the default error handling response dispatcher logic will be used.
     * If the module reacts on the shutdown hook and set's the response state to be dispatched no other
     * error handling shutdown logic will be called to fill up the response.
     *
     * @var int
     */
    const SHUTDOWN = 99;
}
