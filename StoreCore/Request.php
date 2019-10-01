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
            throw new \InvalidArgumentException('Argument passed to ' . __METHOD__ . ' must be UriInterface or URI string, ' . gettype($uri) . ' given');
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
