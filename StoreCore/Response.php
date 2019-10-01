<?php
namespace StoreCore;

use Psr\Http\Message\ResponseInterface;

use StoreCore\Message;
use StoreCore\Registry;

/**
 * Server Response
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Response extends Message implements ResponseInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var int $CompressionLevel
     *   Zlib response compression level.  By default this property is set to
     *   -1 for the default compression provided by the PHP zlib extension.
     */
    protected $CompressionLevel = -1;

    /**
     * @var array $Headers
     *   HTTP response headers.
     */
    protected $Headers = array();

    /**
     * @var string $ReasonPhrase
     *   Response reason phrase associated with the status code.
     *   Defaults to 'OK' for a '200 OK' response.
     */
    private $ReasonPhrase = 'OK';

    /**
     * @var string $ResponseBody
     *   Contents body of the HTTP response.
     */
    protected $ResponseBody;

    /**
     * @var string $StatusCode
     *   HTTP response status code.  Defaults to 200.
     */
    private $StatusCode = 200;


    /**
     * Add an HTTP response header.
     *
     * @param string $header
     *   HTTP header to add to the response.
     *
     * @return void
     */
    public function addHeader($header)
    {
        $this->Headers[] = $header;
    }

    /**
     * Create a gzip compressed string.
     *
     * @param string $data
     *   Response output data to compress.
     *
     * @param int $level
     *   Optional zlib output compression level.  Defaults to -1 for the
     *   default compression of the zlib library.
     *
     * @return string
     *   Compressed version of the `$data` input string.  If the PHP zlib
     *   extension is not installed or compression is disabled, the returned
     *   output is not compressed and the output string is equal to the input
     *   string.
     */
    private function compress($data, $level = -1)
    {
        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }

        if (headers_sent()) {
            return $data;
        }

        $accept_encoding = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_ENCODING', FILTER_SANITIZE_STRING);
        if (
            $accept_encoding === false
            || $accept_encoding === null
            || empty($accept_encoding)
            || !\is_string($accept_encoding)
        ) {
            return $data;
        }

        if (stripos($accept_encoding, 'x-gzip') !== false) {
            $encoding = 'x-gzip';
        } elseif (stripos($accept_encoding, 'gzip') !== false) {
            $encoding = 'gzip';
        } else {
            return $data;
        }

        $this->addHeader('Content-Encoding: ' . $encoding);
        return gzencode($data, (int)$level);
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->ReasonPhrase;
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->StatusCode;
    }

    /**
     * Output the full response.
     *
     * @param void
     * @return void
     */
    public function output()
    {
        if ($this->ResponseBody !== null && $this->CompressionLevel !== 0) {
            $this->ResponseBody = $this->compress($this->ResponseBody, $this->CompressionLevel);
            $this->setCompression(0);
        }

        if (!headers_sent()) {
            if (!empty($this->Headers)) {
                foreach ($this->Headers as $header) {
                    header($header, true);
                }
            }
            header('Referrer-Policy: same-origin', true);
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains', true);
            header('X-Content-Type-Options: nosniff', true);
            header('X-DNS-Prefetch-Control: on', true);
            header('X-Frame-Options: SAMEORIGIN', true);
            header('X-Powered-By: StoreCore', true);
            header('X-UA-Compatible: IE=edge', true);
            header('X-XSS-Protection: 1; mode=block', true);

            /*
             * @todo
             *   This needs more work for specific server, database, and
             *   middleware details.  For now we are simply measuring the total
             *   server processing timing in milliseconds.
             *
             * @see https://www.w3.org/TR/server-timing/
             *      Server Timing (W3C Working Draft 29 December 2017)
             *
             * @see https://secure.php.net/microtime
             *      PHP microtime() function and $_SERVER['REQUEST_TIME_FLOAT']) superglobal
             */
             header('Server-Timing: total;dur=' . round(1000 * (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 1));
        }

        if (
            $this->ResponseBody !== null 
            && filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'HEAD'
        ) {
            echo $this->ResponseBody;
        }
    }

    /**
     * Redirect the HTTP client.
     *
     * @param string $url
     *   URL of the destination location.
     *
     * @param int $status
     *   HTTP response status code.  Defaults to 302 for a permanent redirect.
     *
     * @return void
     */
    public function redirect($url, $status = 302)
    {
        ob_start('ob_gzhandler');
        $url = str_ireplace(array('&amp;', "\n", "\r"), array('&', '', ''), $url);
        header('Location: ' . $url, true, $status);
        exit;
    }

    /**
     * Set the response compression level.
     *
     * @param int|bool $level
     *   The level of output compression, ranging from 0 for no compression up
     *   to 9 for maximum compression.  If not given, the default compression
     *   level will be the default compression level of the zlib library.
     *   Compression may also be enabled/disabled with a true/false.
     *
     * @return void
     */
    public function setCompression($level = -1)
    {
        if ($level === false) {
            $level = 0;
        } elseif ($level === true) {
            $level = -1;
        } elseif (!\is_int($level)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects parameter 1 to be an integer or boolean.');
        }

        if ($level < -1) {
            $level = 1;
        } elseif ($level > 9) {
            $level = 9;
        }

        $this->CompressionLevel = $level;
    }

    /**
     * Set the HTTP response status code.
     *
     * @param int $code
     *   HTTP response status code as an integer.
     */
    public function setStatusCode($code)
    {
        $this->StatusCode = $code;
    }

    /**
     * Set the reason response phrase.
     * 
     * @param string|null $reason_phrase
     *   Reason phrase associated with the response status code.
     *   The reason phrase value MAY be empty.
     *
     * @return void
     */
    public function setReasonPhrase($reason_phrase)
    {
        if ($reason_phrase === null || empty($reason_phrase)) {
            $reason_phrase = '';
        }

        if (!is_string($reason_phrase)) {
            throw new \InvalidArgumentException();
        }

        $this->ReasonPhrase = $reason_phrase;
    }

    /**
     * Set the response content.
     *
     * @param string $output
     * @return void
     */
    public function setResponseBody($output)
    {
        $this->ResponseBody = $output;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reason_phrase = '')
    {
        $response = clone $this;
        $response->setStatusCode($code);
        $response->setReasonPhrase($reason_phrase);
        return $response;
    }
}
