<?php
namespace Psr\Http\Client;

/**
 * Every HTTP client related exception MUST implement this interface.
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-18-http-client.md#clientexceptioninterface
 *
 * @todo Extend the Throwable base interface in PHP 7:
 *       `interface ClientExceptionInterface extends \Throwable`
 */
interface ClientExceptionInterface
{
}
