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

use Psr\Log\LogLevel;
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

    protected $channelName;

    protected $handlers;

    protected $processors;

    /**
     * The log level we want to use.
     *
     * @var integer
     */
    protected $logLevel;

    protected $logLevels = array(
        LogLevel::DEBUG     => 100, // Detailed debug information.
        LogLevel::INFO      => 200, // Interesting events. Examples: User logs in, SQL logs.
        LogLevel::NOTICE    => 250, // Normal but significant events.
        LogLevel::WARNING   => 300, // Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
        LogLevel::ERROR     => 400, // Runtime errors that do not require immediate action but should typically be logged and monitored.
        LogLevel::CRITICAL  => 500, // Critical conditions. Example: Application component unavailable, unexpected exception.
        LogLevel::ALERT     => 550, // Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
        LogLevel::EMERGENCY => 600, // Emergency: system is unusable.
    );

    /**
     * Initializes the logger instance with the log level.
     *
     * @param string  $channelName
     * @param array   $handlers
     * @param array   $processors
     * @param integer $logLevel    The log level we want to use
     */
    public function __construct($channelName, array $handlers = array(), array $processors = array(), $logLevel = LogLevel::INFO)
    {
        $this->channelName = $channelName;
        $this->handlers = $handlers;
        $this->processors = $processors;
        $this->logLevel = $logLevel;
    }

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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        $this->log($message, $context);
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
        // this is a dummy logger
    }

    /**
     * Returns the log level we want to use.
     *
     * @return integer The log level
     */
    protected function getLogLevel()
    {
        return $this->logLevel;
    }

    /**
     * Checks if the message should be logged, depending on the log level.
     *
     * @param string $logLevel The log level to match against
     *
     * @return boolean TRUE if the message should be logged, else FALSE
     */
    protected function shouldLog($logLevel)
    {
        return $this->logLevels[$level] >= $this->logLevels[$this->getLogLevel()];
    }
}
