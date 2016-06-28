<?php

/**
 * \AppserverIo\Server\Configuration\LoggerXmlConfiguration
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

namespace AppserverIo\Server\Configuration;

use AppserverIo\Server\Interfaces\LoggerConfigurationInterface;

/**
 * Class LoggerXmlConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class LoggerXmlConfiguration implements LoggerConfigurationInterface
{

    /**
     * Holds the name of the logger
     * @var string
     */
    protected $name;

    /**
     * Holds the type of the logger
     * @var string
     */
    protected $type;

    /**
     * 'Holds the loggers channel name
     * @var string
     */
    protected $channel;

    /**
     * Holds all handlers defined for logger
     * @var array
     */
    protected $handlers;

    /**
     * Holds all processors defined for logger
     * @var array
     */
    protected $processors;

    /**
     * Constructs config
     *
     * @param \SimpleXMLElement $node The simple xml element used to build config
     */
    public function __construct(\SimpleXMLElement $node)
    {
        // prepare properties
        $this->name = (string)$node->attributes()->name;
        $this->type = (string)$node->attributes()->type;
        if (isset($node->attributes()->channel)) {
            $this->channel = (string)$node->attributes()->channel;
        }

        // prepare handlers
        $this->handlers = $this->prepareHandlers($node);
        // prepare processors
        $this->processors = $this->prepareProcessors($node);
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Returns defined handlers for logger
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Returns defined processors for logger
     *
     * @return array
     */
    public function getProcessors()
    {
        return $this->processors;
    }

    /**
     * Prepares handlers array for config
     *
     * @param \SimpleXMLElement $node The xml node to prepare for
     *
     * @return array
     */
    public function prepareHandlers($node)
    {
        $handlers = array();
        if ($node->handlers) {
            foreach ($node->handlers->handler as $handlerNode) {
                // build up params
                $params = array();

                foreach ($handlerNode->params->param as $paramNode) {
                    $paramName = (string) $paramNode->attributes()->name;
                    $paramNodes = $handlerNode->xpath(".//param[@name='$paramName']");
                    $params[$paramName] = (string) array_shift($paramNodes);
                }
                // build up formatter infos if exists
                if (isset($handlerNode->formatter)) {
                    $formatterType = (string)$handlerNode->formatter->attributes()->type;
                    $formatterParams = array();
                    foreach ($handlerNode->formatter->params->param as $paramNode) {
                        $paramName = (string)$paramNode->attributes()->name;
                        $paramsNameArray = $handlerNode->xpath(".//param[@name='$paramName']");
                        $formatterParams[$paramName] = (string)array_shift($paramsNameArray);
                    }
                    // setup formatter info
                    $handlers[(string)$handlerNode->attributes()->type]['formatter'] = array(
                        'type' => $formatterType,
                        'params' => $formatterParams
                    );
                }
                // set up handler infos
                $handlers[(string)$handlerNode->attributes()->type]['params'] = $params;
            }
        }
        return $handlers;
    }

    /**
     * Prepares processors array for config
     *
     * @param \SimpleXMLElement $node The xml node to prepare for
     *
     * @return array
     */
    public function prepareProcessors($node)
    {
        $processors = array();
        if ($node->processors) {
            foreach ($node->processors->processor as $processorNode) {
                $processors[(string)$processorNode->attributes()->type] = (string)$processorNode->attributes()->type;
            }
        }
        return $processors;
    }
}
