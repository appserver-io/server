<?php

/**
 * \AppserverIo\Server\RequestContextTest
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Library
 * @package    Server
 * @subpackage Tests
 * @author     Johann Zelger <jz@appserver.io>
 * @author     Bernhard Wick <bw@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Http
 */

namespace AppserverIo\Server;

use AppserverIo\Server\Dictionaries\ServerVars;
use AppserverIo\Server\Contexts\RequestContext;

/**
 * Class RequestContextTest
 *
 * @category   Library
 * @package    Server
 * @subpackage Tests
 * @author     Johann Zelger <jz@appserver.io>
 * @author     Bernhard Wick <bw@appserver.io>
 * @copyright  2014 TechDivision GmbH <info@appserver.io>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/TechDivision_Http
 */
class RequestContextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The request context used for our tests
     *
     * @var \TechDivision\Server\Contexts\RequestContext
     */
    public $requestContext;

    /**
     * Initializes server context object to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->requestContext = new RequestContext();
    }

    /**
     * Test set server var functionality on RequestContext object.
     *
     * @return void
     */
    public function testSetServerVarToRequestContextObject()
    {
        $this->requestContext->setServerVar(ServerVars::HTTP_HOST, 'unittest.local:9080');
        $this->requestContext->setServerVar(ServerVars::HTTP_CONNECTION, 'keep-alive');
        $this->requestContext->setServerVar(ServerVars::HTTP_ACCEPT_ENCODING, 'gzip, deflate');

        $this->assertSame('unittest.local:9080', $this->requestContext->getServerVar(ServerVars::HTTP_HOST));
        $this->assertSame('keep-alive', $this->requestContext->getServerVar(ServerVars::HTTP_CONNECTION));
        $this->assertSame('gzip, deflate', $this->requestContext->getServerVar(ServerVars::HTTP_ACCEPT_ENCODING));
    }
}
