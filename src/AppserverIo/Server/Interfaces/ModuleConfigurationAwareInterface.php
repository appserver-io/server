<?php

/**
 * \AppserverIo\Server\Interfaces\ModuleConfigurationAwareInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Interfaces;

/**
 * Interface that describes a module configuration aware module.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface ModuleConfigurationAwareInterface
{

    /**
     * Inject's the passed module configuration into the module instance.
     *
     * @param \AppserverIo\Server\Interfaces\ModuleConfigurationInterface $moduleConfiguration The module configuration to inject
     *
     * @return void
     */
    public function injectModuleConfiguration(ModuleConfigurationInterface $moduleConfiguration);

    /**
     * Return's the module configuration.
     *
     * @return \AppserverIo\Server\Interfaces\ModuleConfigurationInterface The module configuration
     */
    public function getModuleConfiguration();
}
