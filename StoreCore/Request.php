<?php
namespace StoreCore;

/**
 * Client Request
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.0.1
 */
class Request
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /** @type string $HostName */
    private $HostName;

    /** @type string|null $RequestMethod */
    private $RequestMethod;

    /** @type string $RequestPath */
    private $RequestPath = '/';

    /**
     * @type array|null $Cookies
     * @type array      $Server
     */
    private $Cookies;
    private $Server;

    public function __construct()
    {
        $magic_quotes_gpc = get_magic_quotes_gpc();

        // Set internal character encoding to UTF-8
        mb_internal_encoding('UTF-8');

        // Server variables
        $data = array();
        foreach ($_SERVER as $key => $value) {
            $value = trim($value);
            if (!empty($value)) {
                if ($magic_quotes_gpc !== false) {
                    $value = stripslashes($value);
                }
                $data[mb_strtoupper($key)] = strip_tags($value);
            }
        }
        $this->Server = $data;

        // Request method (GET, POST, HEAD, etc.)
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if ($magic_quotes_gpc !== false) {
                $_SERVER['REQUEST_METHOD'] = stripslashes($_SERVER['REQUEST_METHOD']);
            }
            $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
            unset($this->Server['REQUEST_METHOD']);
        }

        // Request path (URI without host)
        if (isset($_SERVER['REQUEST_URI'])) {
            if ($magic_quotes_gpc !== false) {
                $_SERVER['REQUEST_URI'] = stripslashes($_SERVER['REQUEST_URI']);
            }
            $this->setRequestPath($_SERVER['REQUEST_URI']);
            unset($this->Server['REQUEST_URI']);
        }

        // Add cookie data
        if (isset($_COOKIE) && !empty($_COOKIE)) {
            $data = array();
            foreach ($_COOKIE as $name => $value) {
                if (is_string($name) && !empty($value)) {
                    if ($magic_quotes_gpc !== false) {
                        $name = stripslashes($name);
                        $value = stripslashes($value);
                    }
                    $name = mb_strtolower($name);
                    $data[$name] = $value;
                }
            }
            if (count($data) > 1) {
                $this->Cookies = $data;
            }
        }
    }

    /**
     * Get a cookie by name.
     *
     * @param string $cookie_name
     * @return mixed|null
     */
    public function getCookie($cookie_name)
    {
        if ($this->hasCookie[$cookie_name]) {
            return $this->Cookies[$cookie_name];
        } else {
            return null;
        }
    }

    /**
     * Get the host name.
     *
     * @return string
     *     Returns the HTTP host being requested.
     */
    public function getHostName()
    {
        if ($this->HostName == null) {
            $this->setHostName();
        }
        return $this->HostName;
    }

    /**
     * Get the current request method.
     *
     * @param void
     * @return string|null
     */
    public function getRequestMethod()
    {
        return $this->RequestMethod;
    }

    /**
     * Get the current request path.
     *
     * @param void
     * @return string
     */
    public function getRequestPath()
    {
        return $this->RequestPath;
    }

    /**
     * Get the HTTP User-Agent request-header field.
     *
     * @param void
     * @return string
     */
    public function getUserAgent()
    {
        if (array_key_exists('HTTP_USER_AGENT', $this->Server)) {
            return $this->Server['HTTP_USER_AGENT'];
        }
        return (string)null;
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $cookie_name
     * @return bool
     */
    public function hasCookie($cookie_name)
    {
        if (!is_array($this->Cookies)) {
            return false;
        }
        return array_key_exists($cookie_name, $this->Cookies);
    }

    /**
     * Set the requested host name.
     *
     * @param void
     * @return void
     */
    private function setHostName()
    {
        if (isset($this->Server['HTTP_HOST']) && !empty($this->Server['HTTP_HOST'])) {
            $host_name = $this->Server['HTTP_HOST'];
        } else {
            $host_name = gethostname();
        }

        $host_name = preg_replace('/:\d+$/', '', $host_name);
        $host_name = mb_strtolower($str, 'UTF-8');
        $this->HostName = $host_name;
    }

    /**
     * Set the request method.
     *
     * The HTTP request method in the superglobal PHP variable
     * $_SERVER['REQUEST_METHOD'] is controlled by the client.  It MAY be
     * considered reliable as long as the web server allows only certain
     * request methods.
     *
     * @param string $method
     * @return void
     */
    private function setRequestMethod($method)
    {
        if (!is_string($method)) {
            return;
        }

        $method = strip_tags($method);
        $method = trim($method);
        $method = strtoupper($method);

        if (!empty($method)) {
            $this->RequestMethod = $method;
        }
    }

    /**
     * Set the request path.
     *
     * @param string $path
     * @return void
     */
    private function setRequestPath($path)
    {
        $path = urldecode($path);
        $path = mb_strtolower($path, 'UTF-8');
        $path = str_ireplace('/index.php', '/', $path);
        $this->RequestPath = $path;
    }
}
