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
namespace Nia\RequestResponse\Cli;

use Nia\Collection\Map\StringMap\Map;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Collection\Map\StringMap\ReadOnlyMap;
use Nia\RequestResponse\ResponseInterface;

/**
 * CLI request implementation.
 */
class CliRequest implements CliRequestInterface
{

    /**
     * The request arguments.
     *
     * @var MapInterface
     */
    private $arguments = null;

    /**
     * The request path.
     *
     * @var string
     */
    private $path = null;

    /**
     * The input stream.
     *
     * @var resource
     */
    private $stream = null;

    /**
     * Constructor.
     *
     * @param string[] $arguments
     *            List with raw arguments.
     * @param resource $stream
     *            The input stream.
     */
    public function __construct(array $arguments, $stream)
    {
        $this->arguments = $this->readArguments($arguments);
        $this->path = $this->readPath($arguments);
        $this->stream = $stream;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::getMethod()
     */
    public function getMethod(): string
    {
        return self::METHOD_CLI;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::getHeader()
     */
    public function getHeader(): MapInterface
    {
        return new ReadOnlyMap(new Map());
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::getArguments()
     */
    public function getArguments(): MapInterface
    {
        return $this->arguments;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::getPath()
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::getContent()
     */
    public function getContent(): string
    {
        return (string) fgets($this->stream);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\RequestInterface::createResponse()
     */
    public function createResponse(): ResponseInterface
    {
        return new CliResponse($this);
    }

    /**
     * Reads the arguments as a map from a list of raw arguments.
     *
     * @param string[] $arguments
     *            List with raw arguments.
     * @return MapInterface Readed arguments as a map.
     */
    private function readArguments(array $arguments): MapInterface
    {
        $result = new Map();

        $regex = '/^--(?P<name>[a-z_][a-z0-9_-]*)(\=(?P<value>(.*)))?$/i';
        $matches = [];

        foreach ($arguments as $argument) {
            if (preg_match($regex, $argument, $matches) !== 0) {
                $result->set($matches['name'], trim($matches['value'] ?: '', '"'));
            }
        }

        return new ReadOnlyMap($result);
    }

    /**
     * Reads the path from passed raw arguments.
     *
     * @param string[] $arguments
     *            List with raw arguments.
     * @return string The readed path.
     */
    private function readPath(array $arguments): string
    {
        foreach ($arguments as $argument) {
            if (strpos($argument, '/') === 0) {
                return $argument;
            }
        }

        return '/';
    }
}
