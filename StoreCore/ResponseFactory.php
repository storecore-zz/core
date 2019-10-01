<?php
namespace StoreCore;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

use StoreCore\Registry;
use StoreCore\Response;

/**
 * HTTP Response Factory
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string $StatusCodes
     *   HTTP response status codes.
     */
    private $StatusCodes = array(
        100 => 'Continue',
        101 => 'Switching Protocol',
        102 => 'Processing',

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Multi-Status',
        226 => 'IM Used',

        300 => 'Multiple Choice',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

    /**
     * @inheritDoc
     */
    public function createResponse($code = 200, $reason_phrase = '')
    {
        if (!is_int($code) || !array_key_exists($code, $this->StatusCodes) ) {
            throw new \InvalidArgumentException();
        }

        if ($reason_phrase === null || empty($reason_phrase)) {
            $reason_phrase = $this->StatusCodes[$code];
        } elseif (!is_string($reason_phrase)) {
            throw new \InvalidArgumentException();
        }

        $response = new Response(Registry::getInstance());
        $response->setStatusCode($code);
        $response->setReasonPhrase($reason_phrase);
        if (\defined('STORECORE_RESPONSE_COMPRESSION_LEVEL')) {
            $response->setCompression(STORECORE_RESPONSE_COMPRESSION_LEVEL);
        }
        return $response;
    }
}
