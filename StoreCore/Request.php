<?php
namespace StoreCore;

use \StoreCore\Types\StringableInterface;

/**
 * Client Request
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Request
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /** @var string $HostName */
    private $HostName;

    /**
     * @var string $Method
     *   HTTP method of the request.  Defaults to a `GET` request.
     */
    private $Method = 'GET';

    /**
     * @var string $RequestTarget
     *   Target of the HTTP request.  Defaults to '/' for the root, the homepage,
     *   or the front controller.
     */
    private $RequestTarget = '/';

    /**
     * @var array $SupportedMethods
     *   HTTP request methods supported by the class.  This array may be
     *   overwritten by extending classes to limit the types of allowed request
     *   methods for specific applications.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *      HTTP request methods
     */
    protected $SupportedMethods = array(
        'CONNECT' => true,
        'DELETE'  => true,
        'GET'     => true,
        'HEAD'    => true,
        'OPTIONS' => true,
        'PATCH'   => true,
        'POST'    => true,
        'PUT'     => true,
        'TRACE'   => true,
    );

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
     * @return self
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
                    $key = mb_strtoupper($key);
                    $data[$key] = strip_tags($value);
                }
            }
        }
        $this->Server = $data;

        /*
         * Set the HTTP request method (POST, HEAD, PUT, etc.) other than the
         * default method (GET).  The HTTP request method in the superglobal
         * PHP variable $_SERVER['REQUEST_METHOD'] is controlled by the client.
         * It MAY be considered reliable as long as the web server allows only
         * certain request methods.
         */
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && ($_SERVER['REQUEST_METHOD'] !== $this->getMethod())
            && is_string($_SERVER['REQUEST_METHOD'])
        ) {
            if ($magic_quotes_gpc !== false) {
                $_SERVER['REQUEST_METHOD'] = stripslashes($_SERVER['REQUEST_METHOD']);
            }
            $this->setMethod(strtoupper($_SERVER['REQUEST_METHOD']));
        }

        // Request path (URI without host)
        if (isset($_SERVER['REQUEST_URI'])) {
            $request_target = $_SERVER['REQUEST_URI'];
            if ($magic_quotes_gpc !== false) {
                $request_target = stripslashes($request_target);
            }
            if (strpos($request_target, '?') !== false) {
                $request_target = strtok($request_target, '?');
            }
            $request_target = rawurldecode($request_target);
            $request_target = mb_strtolower($request_target, 'UTF-8');
            $request_target = str_ireplace('/index.php', '/', $request_target);
            $this->setRequestTarget($request_target);
        }

        // Posted data
        if ($this->getMethod() === 'POST') {
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
            if (!empty($data)) {
                $this->Cookies = $data;
            }
        }
    }

    /**
     * Get a request value by name.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (!is_string($key)) {
            return null;
        }

        // Keys are case-insensitive, but are stored in lower case.
        $key = mb_strtolower($key, 'UTF-8');

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
     * @param void
     * @return string
     */
    public function getAcceptEncoding()
    {
        if (array_key_exists('HTTP_ACCEPT_ENCODING', $this->Server)) {
            return $this->Server['HTTP_ACCEPT_ENCODING'];
        } else {
            return '';
        }
    }

    /**
     * Get a cookie by name.
     *
     * @param string $cookie_name
     *   Case-insensitive name of a cookie.
     *
     * @return mixed|null
     *   Returns the contents of a cookie or null if the cookie does not exist.
     */
    public function getCookie($cookie_name)
    {
        $cookie_name = mb_strtolower($cookie_name, 'UTF-8');
        return $this->hasCookie($cookie_name) ? $this->Cookies[$cookie_name] : null;
    }

    /**
     * Get the host name.
     *
     * @return string
     *   Returns the HTTP host being requested.
     */
    public function getHostName()
    {
        if ($this->HostName === null) {
            $this->setHostName();
        }
        return $this->HostName;
    }

    /**
     * Get the current request method.
     *
     * @param void
     * @return string
     */
    public function getMethod()
    {
        return $this->Method;
    }

    /**
     * Get the client IP address.
     *
     * @param void
     * @return string
     */
    public function getRemoteAddress()
    {
        return $this->Server['REMOTE_ADDR'];
    }

    /**
     * Get the message’s request target.
     *
     * @param void
     *
     * @return string
     *   In most cases, this method will be the origin-form of the composed URI,
     *   unless a value was provided to the concrete implementation.  If no URI
     *   is available, and no request-target has been specifically provided,
     *   this method will return the string '/'.
     */
    public function getRequestTarget()
    {
        return $this->RequestTarget;
    }

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @param void
     * @return array
     */
    public function getServerParams()
    {
        return $this->Server;
    }

    /**
     * Get the HTTP User-Agent request-header field.
     *
     * @param void
     * @return string|null
     */
    public function getUserAgent()
    {
        return array_key_exists('HTTP_USER_AGENT', $this->Server) ? $this->Server['HTTP_USER_AGENT'] : null;
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $cookie_name
     *   Case-insensitive name of a cookie.
     *
     * @return bool
     *   Returns true if the cookie exists, otherwise false.
     */
    public function hasCookie($cookie_name)
    {
        if (!is_array($this->Cookies)) {
            return false;
        }
        $cookie_name = mb_strtolower($cookie_name);
        return array_key_exists($cookie_name, $this->Cookies);
    }

    /**
     * Check if HTTP/S and SSL are used.
     *
     * @param void
     * @return bool
     */
    public function isSecure()
    {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    /**
     * Set the requested host name.
     *
     * @param void
     * @return void
     */
    private function setHostName()
    {
        if (array_key_exists('HTTP_HOST', $this->Server)) {
            $host_name = $this->Server['HTTP_HOST'];
        } else {
            $host_name = gethostname();
        }
        $host_name = preg_replace('/:\d+$/', '', $host_name);
        $host_name = mb_strtolower($host_name, 'UTF-8');
        $this->HostName = $host_name;
    }

    /**
     * Set the HTTP request method.
     *
     * @param string $method
     *   Case-insensitive name of the HTTP method.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$method` parameter is not
     *   a valid HTTP method.
     *
     * @throws \OutOfBoundsException
     *   Throws an out of bounds runtime exception if the HTTP is valid but is
     *   not supported by the current application or request end point.
     */
    public function setMethod($method)
    {
        if (!is_string($method) || empty($method)) {
            throw new \InvalidArgumentException();
        }

        $method = trim($method);
        $uppercase_method = strtoupper($method);
        if (!array_key_exists($uppercase_method, $this->SupportedMethods)) {
            throw new \InvalidArgumentException();
        } elseif ($this->SupportedMethods[$uppercase_method] !== true) {
            throw new \OutOfBoundsException();
        } else {
            $this->Method = $method;
        }
    }

    /**
     * Set the request target.
     *
     * @param string|\StoreCore\Types\StringableInterface $request_target
     *   Target path of the current request as a string or an object that can
     *   be converted to a string.
     *
     * @return void
     */
    public function setRequestTarget($request_target)
    {
        $this->RequestTarget = (string)$request_target;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        $request = clone $this;
        $request->setMethod($method);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($request_target)
    {
        $request = clone $this;
        $request->setRequestTarget($request_target);
        return $request;
    }
}
