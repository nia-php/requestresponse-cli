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

use Nia\RequestResponse\RequestInterface;

/**
 * Interface for all CLI request implementations.
 */
interface CliRequestInterface extends RequestInterface
{

    /**
     * Constant for request method CLI.
     *
     * @var string
     */
    const METHOD_CLI = 'CLI';
}
