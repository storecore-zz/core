<?php
namespace StoreCore;

/**
 * Server Response
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.0.1
 */
class Response extends AbstractModel
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /**
     * @type int               $CompressionLevel
     * @type array             $Headers
     * @type StoreCore\Request $Request
     * @type string            $ResponseBody
     */
    private $CompressionLevel = -1;
    private $Headers;
    private $Request;
    private $ResponseBody;

    /**
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
     * @param string $data
     * @param int $level
     * @return string|bool
     */
    private function compress($data, $level = -1)
    {
        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }

        if (headers_sent()) {
            return $data;
        }

        if ($level < -1 || $level > 9) {
            return $data;
        }

        if (connection_status()) {
            return $data;
        }

        if ($this->Request == null) {
            $this->Request = $this->Registry->get('Request');
        }
        $accept_encoding = $this->Request->getAcceptEncoding();
        if (empty($accept_encoding)) {
            return $data;
        }

        if (stripos($accept_encoding, 'x-gzip') !== false) {
            $encoding = 'x-gzip';
        } elseif (stripos($accept_encoding, 'gzip') !== false) {
            $encoding = 'gzip';
        }
        if (!isset($encoding)) {
            return $data;
        }

        $this->addHeader('Content-Encoding: ' . $encoding);
        return gzencode($data, (int)$level);
    }

    /**
     * Output the full response.
     *
     * @param void
     * @return void
     */
    public function output()
    {
        if ($this->ResponseBody) {
            if ($this->CompressionLevel !== 0) {
                $output = $this->compress($this->ResponseBody, $this->CompressionLevel);
                if ($output !== false) {
                    $this->setResponseBody($output);
                    $this->setCompression(0);
                }
            }
        }

        if (!headers_sent()) {
            foreach ($this->Headers as $header) {
                header($header, true);
            }
        }

        if ($this->ResponseBody) {
            $request = $this->Registry->get('Request');
            if ($request->getRequestMethod() !== 'HEAD') {
                echo $this->ResponseBody;
            }
        }
    }

    /**
     * @param string $url
     * @param int $status
     * @return void
     */
    public function redirect($url, $status = 302)
    {
        $url = str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url);
        header('Location: ' . $url, true, $status);
        exit;
    }

    /**
     * Set the response compression level.
     *
     * @param int $level
     *     The level of output compression, ranging from 0 for no compression
     *     up to 9 for maximum compression.   If not given, the default
     *     compression level will be the default compression level of the
     *     zlib library.
     *
     * @return void
     */
    public function setCompression($level = -1)
    {
        $this->CompressionLevel = (int)$level;
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
}
