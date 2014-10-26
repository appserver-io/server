<?php
/**
 * \TechDivision\WebServer\Loggers\DummyLogger
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Webserver
 * @package    TechDivision_WebServer
 * @subpackage Loggers
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_WebServer
 */

namespace TechDivision\Server\Loggers;

use Psr\Log\LoggerInterface;

/**
 * Class DummyLogger
 *
 * @category   Webserver
 * @package    TechDivision_WebServer
 * @subpackage Loggers
 * @author     Johann Zelger <jz@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_WebServer
 */
class DummyLogger implements LoggerInterface
{
    /**
     * System is unusable.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        // dummy
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function alert($message, array $context = array())
    {
        // dummy
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function critical($message, array $context = array())
    {
        // dummy
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function error($message, array $context = array())
    {
        // dummy
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function warning($message, array $context = array())
    {
        // dummy
    }

    /**
     * Normal but significant events.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function notice($message, array $context = array())
    {
        // dummy
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function info($message, array $context = array())
    {
        // dummy
    }

    /**
     * Detailed debug information.
     *
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function debug($message, array $context = array())
    {
        // dummy
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   The log level
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        // dummy
    }
}
