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
    /** @var string VERSION */
    const VERSION = '0.0.1';

    /** @var string $HostName */
    private $HostName;

    /** @var string|null $RequestMethod */
    private $RequestMethod;

    /** @var string $RequestPath */
    private $RequestPath = '/';

    /**
     * @var array|null $Cookies
     * @var array|null $Get
     * @var array|null $Post
     * @var array      $Server
     */
    private $Cookies;
    private $Get;
    private $Post;
    private $Server;

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        $magic_quotes_gpc = get_magic_quotes_gpc();

        // Set internal character encoding to UTF-8
        mb_internal_encoding('UTF-8');

        // Non-empty $_SERVER string variables
        $data = array();
        foreach ($_SERVER as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
                if ($magic_quotes_gpc !== false) {
                    $value = stripslashes($value);
                }
                if (!empty($value)) {
                    $data[mb_strtoupper($key)] = strip_tags($value);
                }
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

        // Posted data
        if ($this->getRequestMethod() == 'POST') {
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_string($value)) {
                    $value = trim($value);
                    if ($magic_quotes_gpc !== false) {
                        $key = stripslashes($key);
                        $value = stripslashes($value);
                    }
                    $value = strip_tags($value);
                    if (!empty($value)) {
                        $data[mb_strtolower($key)] = $value;
                    }
                }
            }
            $this->Post = $data;
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
     * Get a request value by name.
     *
     * @api
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if ($this->Post !== null && array_key_exists($key, $this->Post)) {
            return $this->Post[$key];
        } elseif ($this->Get !== null && array_key_exists($key, $this->Get)) {
            return $this->Get[$key];
        } else {
            return null;
        }
    }

    /**
     * Get the HTTP "Accept-Encoding" request-header field.
     *
     * @api
     * @param void
     * @return string
     */
    public function getAcceptEncoding()
    {
        if (array_key_exists('HTTP_ACCEPT_ENCODING', $this->Server)) {
            return $this->Server['HTTP_ACCEPT_ENCODING'];
        }
        return (string)null;
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
     * @api
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
     * @api
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
     * @api
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
     * @internal
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
        $host_name = mb_strtolower($host_name, 'UTF-8');
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
     * @internal
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
     * @internal
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
