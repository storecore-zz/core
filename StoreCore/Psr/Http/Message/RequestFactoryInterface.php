<?php
namespace Psr\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

interface RequestFactoryInterface
{
    /**
     * Create a new request.
     *
     * @param string $method
     *   The HTTP method associated with the request.
     *
     * @param UriInterface|string $uri
     *   The URI associated with the request.
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest($method, $uri);
}
