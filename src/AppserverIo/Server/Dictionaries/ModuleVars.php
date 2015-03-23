<?php

/**
 * \AppserverIo\Server\Dictionaries\ModuleVars
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
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Dictionaries;

/**
 * Class ModuleVars which is used by different modules to communicate with each
 * other without knowing each other.
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ModuleVars
{
    /**
     * Constants which define possible entries for our context storage
     *
     * @const string
     */
    const VOLATILE_REWRITES = 'VOLATILE_REWRITES';
    const VOLATILE_ENVIRONMENT_VARIABLES = 'VOLATILE_ENVIRONMENT_VARIABLES';
    const VOLATILE_ACCESSES = 'VOLATILE_ACCESSES';
    const VOLATILE_ANALYTICS = 'VOLATILE_ANALYTICS';
    const VOLATILE_LOCATIONS = 'VOLATILE_LOCATIONS';
    const VOLATILE_REWRITE_MAPS = 'VOLATILE_REWRITE_MAPS';
    const VOLATILE_FILE_HANDLER_VARIABLES = 'VOLATILE_FILE_HANDLER_VARIABLES';
    const VOLATILE_AUTHENTICATIONS = 'VOLATILE_AUTHENTICATIONS';
    const VOLATILE_HANDLERS = 'VOLATILE_HANDLERS';
}
