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
use Nia\RequestResponse\Cli\CliRequest;
use Nia\RequestResponse\Cli\CliRequestInterface;
use Nia\RequestResponse\Cli\CliResponseInterface;
use Nia\RequestResponse\RequestInterface;

/**
 * Unit test for \Nia\RequestResponse\Cli\CliRequest.
 */
class CliRequestTest extends PHPUnit_Framework_TestCase
{

    /** @var RequestInterface */
    private $request = null;

    private $stream = null;

    protected function setUp()
    {
        $this->stream = fopen('php://temp', 'r+');
        fwrite($this->stream, 'foobar');
        rewind($this->stream);

        $this->request = new CliRequest([
            '--foo=bar',
            '--bar=foo',
            '/my/path.txt'
        ], $this->stream);
    }

    protected function tearDown()
    {
        fclose($this->stream);
        $this->request = null;
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::getMethod
     */
    public function testGetMethod()
    {
        $this->assertSame(CliRequestInterface::METHOD_CLI, $this->request->getMethod());
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::getHeader
     */
    public function testGetHeader()
    {
        $this->assertSame([], iterator_to_array($this->request->getHeader()
            ->getIterator()));
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::getArguments
     */
    public function testGetArguments()
    {
        $expected = [
            'foo' => 'bar',
            'bar' => 'foo'
        ];

        $this->assertSame($expected, iterator_to_array($this->request->getArguments()
            ->getIterator()));
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::getPath
     */
    public function testGetPath()
    {
        $this->assertSame('/my/path.txt', $this->request->getPath());

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, 'foobar');
        rewind($stream);

        // test without path
        $request = new CliRequest([
            '--foo=bar',
            '--bar=foo'
        ], $stream);

        $this->assertSame('/', $request->getPath());

        fclose($stream);
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::getContent
     */
    public function testGetContent()
    {
        $this->assertSame('foobar', $this->request->getContent());
        $this->assertSame('', $this->request->getContent());
    }

    /**
     * @covers \Nia\RequestResponse\Cli\CliRequest::createResponse
     */
    public function testCreateResponse()
    {
        $this->assertInstanceOf(CliResponseInterface::class, $this->request->createResponse());
    }
}
