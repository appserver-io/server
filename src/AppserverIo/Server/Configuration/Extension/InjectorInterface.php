<?php

/**
 * AppserverIo\Server\Configuration\Extension\InjectorInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH - <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://www.github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Configuration\Extension;

/**
 * Interface for injector classes
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH - <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://www.github.com/appserver-io/server
 * @link      http://www.appserver.io
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
