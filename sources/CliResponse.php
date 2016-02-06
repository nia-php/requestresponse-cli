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

use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\Collection\Map\StringMap\Map;
use Nia\RequestResponse\ResponseInterface;

/**
 * CLI response implementation.
 */
class CliResponse implements CliResponseInterface
{

    /**
     * The request which created this response.
     *
     * @var CliRequestInterface
     */
    private $request = null;

    /**
     * The response status code.
     *
     * @var int
     */
    private $statusCode = 0;

    /**
     * Response header as map.
     *
     * @var MapInterface
     */
    private $header = null;

    /**
     * Response content.
     *
     * @var string
     */
    private $content = '';

    /**
     * Constructor.
     *
     * @param CliRequestInterface $request
     *            The request which created this response.
     */
    public function __construct(CliRequestInterface $request)
    {
        $this->request = $request;
        $this->header = new Map();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::setStatusCode($statusCode)
     */
    public function setStatusCode(int $statusCode): ResponseInterface
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::getStatusCode()
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::setContent($content)
     */
    public function setContent(string $content): ResponseInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::getContent()
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::getHeader()
     */
    public function getHeader(): WriteableMapInterface
    {
        return $this->header;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\RequestResponse\ResponseInterface::getRequest()
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
