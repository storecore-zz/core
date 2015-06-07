<?php
namespace StoreCore;

/**
 * Server Response
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.1.0-alpha.1
 */
class Response extends AbstractController
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * @type int    $CompressionLevel
     * @type array  $Headers
     * @type string $ResponseBody
     */
    protected $CompressionLevel = -1;
    protected $Headers;
    protected $ResponseBody;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        if (defined('\\StoreCore\\RESPONSE_COMPRESSION_LEVEL')) {
            $this->setCompression(\StoreCore\RESPONSE_COMPRESSION_LEVEL);
        }
    }

    /**
     * @api
     * @param string $header
     * @return void
     */
    public function addHeader($header)
    {
        $this->Headers[] = $header;
    }

    /**
     * Create a gzip compressed string.
     *
     * @internal
     * @param string $data
     * @param int $level
     * @return string
     */
    private function compress($data, $level = -1)
    {
        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }

        if (headers_sent()) {
            return $data;
        }

        $accept_encoding = $this->Request->getAcceptEncoding();
        if (empty($accept_encoding)) {
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
     * Output the full response.
     *
     * @api
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
            if ($this->Headers !== null) {
                foreach ($this->Headers as $header) {
                    header($header, true);
                }
            }
            header('X-Frame-Options: SAMEORIGIN', true);
            header('X-Powered-By: StoreCore/' . \StoreCore\VERSION, true);
            header('X-UA-Compatible: IE=edge', true);
        }

        if ($this->ResponseBody !== null && $this->Request->getRequestMethod() !== 'HEAD') {
            echo $this->ResponseBody;
        }
    }

    /**
     * @api
     * @param string $url
     * @param int $status
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
     * @api
     *
     * @param int|bool $level
     *   The level of output compression, ranging from 0 for no compression up
     *   to 9 for maximum compression.   If not given, the default compression
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
        } elseif (!is_int($level)) {
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
     * Set the response content.
     *
     * @api
     * @param string $output
     * @return void
     */
    public function setResponseBody($output)
    {
        $this->ResponseBody = $output;
    }
}
