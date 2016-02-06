<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\RequestResponse\Cli;

use PHPUnit_Framework_TestCase;
use Nia\RequestResponse\Cli\CliResponse;
use Nia\RequestResponse\Cli\CliRequestInterface;
use Nia\RequestResponse\Cli\CliResponseInterface;
use Nia\RequestResponse\RequestInterface;

/**
 * Unit test for \Nia\RequestResponse\Cli\CliResponse.
 */
class CliResponseTest extends PHPUnit_Framework_TestCase
{

    /** @var CliResponseInterface */
    private $response = null;

    protected function setUp()
    {
        $this->response = new CliResponse($this->getMock(CliRequestInterface::class));
    }

    protected function tearDown()
    {
        $this->response = null;
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliResponse::setStatusCode
     * @covers \Nia\RequestResponse\Cli\CliResponse::getStatusCode
     */
    public function testSetGetStatusCode()
    {
        $this->assertSame(0, $this->response->getStatusCode());

        $this->assertSame($this->response, $this->response->setStatusCode(1234));

        $this->assertSame(1234, $this->response->getStatusCode());
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliResponse::setContent
     * @covers \Nia\RequestResponse\Cli\CliResponse::getContent
     */
    public function testSetGetContent()
    {
        $this->assertSame('', $this->response->getContent());

        $this->assertSame($this->response, $this->response->setContent('x foobar x'));

        $this->assertSame('x foobar x', $this->response->getContent());
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliResponse::getHeader
     */
    public function testGetHeader()
    {
        $this->assertSame(false, $this->response->getHeader()
            ->has('foo'));

        $this->response->getHeader()->set('foo', 'bar');

        $this->assertSame(true, $this->response->getHeader()
            ->has('foo'));
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliResponse::getRequest
     */
    public function testGetRequest()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->response->getRequest());
    }
}
