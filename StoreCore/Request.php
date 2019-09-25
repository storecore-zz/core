<?php
namespace StoreCore;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\UriInterface;
use \StoreCore\Message;
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
class Request extends Message implements RequestInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

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
     * @var UriInterface $Uri
     *   Uniform resource identifier (URI) with a UriInterface.
     */
    private $Uri;

    /**
     * @var array|null $Get
     * @var array|null $Post
     * @var array      $Server
     */
    private $Get;
    private $Post;
    private $Server;

    /**
     * @param void
     * @return self
     */
    public function __construct()
    {
        // Set internal character encoding to UTF-8
        mb_internal_encoding('UTF-8');

        // Non-empty $_SERVER string variables
        $data = array();
        foreach ($_SERVER as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
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
            $this->setMethod(strtoupper($_SERVER['REQUEST_METHOD']));
        }

        // Request path (URI without host)
        if (isset($_SERVER['REQUEST_URI'])) {
            $request_target = $_SERVER['REQUEST_URI'];
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
                    $value = strip_tags($value);
                    if (!empty($value)) {
                        $data[mb_strtolower($key)] = $value;
                    }
                }
            }
            $this->Post = $data;
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
     * @inheritDoc
     */
    public function getUri()
    {
        if ($this->Uri === null) {
            $this->Uri = LocationFactory::getCurrentLocation();
        }

        return $this->Uri;
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
     * Check if secure HTTPS is used.
     *
     * @param void
     *
     * @return bool
     *   Returns true if the request uses HTTPS, otherwise false.
     */
    public function isSecure()
    {
        if ($this->Uri !== null && $this->Uri->getMethod() === 'https') {
            return true;
        } else {
            return false;
        }
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
     * Set the request URI.
     *
     * @param string|UriInterface
     *   Uniform resource identifier (URI) of the request as an URL string or
     *   a PSR-7 compliant UriInterface object.
     *
     * @return void
     */
    public function setUri($uri)
    {
        if ($uri instanceof UriInterface) {
            $this->Uri = $uri;
        } elseif (is_string($uri)) {
            try {
                $factory = new LocationFactory();
                $this->Uri = $factory->createUri($uri);
            } catch (\Exception $e) {
                throw $e;
            }
        } else {
            throw new \InvalidArgumentException('Argument passed to ' .  __METHOD__ . ' must be UriInterface or URI string, ' . gettype($uri) . ' given');
        }
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

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        if ($preserveHost) {
            $current_uri = $this->getUri();
            $current_host = $current_uri->getHost();

            /* 
             * Full decision tree if $preserveHost is true:

                if (empty($current_host) && !empty($uri->getHost())) {
                    // If the Host header is missing or empty, and the new URI
                    // contains a host component, this method MUST update the
                    // Host header in the returned request.
                } elseif (empty($current_host) && empty($uri->getHost())) {
                    // If the Host header is missing or empty, and the new URI
                    // does not contain a host component, this method MUST NOT
                    //  update the Host header in the returned request.
                } elseif (!empty($current_host)) {
                    // If a Host header is present and non-empty, this method
                    // MUST NOT update the Host header in the returned request.
                    $uri->setHost($current_host);
                }
            */
            if (!empty($current_host)) {
                $uri->setHost($current_host);
            }
        }

        $request = clone $this;
        $request->setUri($uri);
        return $request;
    }
}
