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
 * AppserverIo\Server\Configuration\Extension\InjectorInterface
 *
 * Interface for injector classes
 *
 * @category   Appserver
 * @package    Server
 * @subpackage Configuration
 * @author     Bernhard Wick <bw@appserver.io>
 * @copyright  2014 TechDivision GmbH - <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://www.github.com/appserver-io/server
 */
interface InjectorInterface
{
    /**
     * Will init the injector's datasource
     *
     * @return void
     */
    public function init();

    /**
     * Will return a variable of the injector type containing the injectors data
     *
     * @return mixed
     */
    public function extract();
}
