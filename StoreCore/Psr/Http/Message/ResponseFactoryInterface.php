<?php
namespace Psr\Http\Message;

use Psr\Http\Message\ResponseInterface;

interface ResponseFactoryInterface
{
    /**
     * Create a new response.
     *
     * @param int $code
     *   The HTTP status code. Defaults to 200.
     *
     * @param string $reasonPhrase
     *   The reason phrase to associate with the status code in the generated
     *   response.  If none is provided, implementations MAY use the defaults
     *   as suggested in the HTTP specification.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createResponse($code = 200, $reasonPhrase = '');
}
