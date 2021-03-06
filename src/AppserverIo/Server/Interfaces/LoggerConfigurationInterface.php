<?php

/**
 * \AppserverIo\Server\Interfaces\LoggerConfigurationInterface
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

namespace AppserverIo\Server\Interfaces;

/**
 * Interface LoggerConfigurationInterface
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
interface LoggerConfigurationInterface
{
    /**
     * Return's name
     *
     * @return string
     */
    public function getName();

    /**
     * Return's type
     *
     * @return string
     */
    public function getType();

    /**
     * Return's channel
     *
     * @return string
     */
    public function getChannel();

    /**
     * Return's defined handlers for logger
     *
     * @return array
     */
    public function getHandlers();

    /**
     * Return's defined processors for logger
     *
     * @return array
     */
    public function getProcessors();
}
