<?php
namespace StoreCore;

use StoreCore\Types\StringableInterface;
use Psr\Http\Message\UriInterface;

/**
 * Uniform Resource Identifier (URI).
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.2.0
 *
 * @see       https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/Identifying_resources_on_the_Web
 *            Identifying resources on the Web
 */
class Location implements StringableInterface, UriInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.2.0';

    /**
     * @var string $Fragment
     *   Fragment component of the URI.
     */
    private $Fragment = '';

    /**
     * @var string $Host;
     *   Host component of the URI.
     */
    private $Host = '';

    /**
     * @var null|string $Password;
     *   Password in the user information component of the URI.
     */
    private $Password;

    /**
     * @var string $Path;
     *   Path component of the URI.
     */
    private $Path = '';

    /**
     * @var string $Port
     *   Port component of the URI as an integer or null for the default port
     *   of the current scheme.
     */
    private $Port;

    /**
     * @var string $Query
     *   Query string of the URI.
     */
    private $Query = '';

    /**
     * @var string $Scheme
     *   Scheme component of the URI.
     */
    private $Scheme = '';

    /**
     * @var string $UserName;
     *   User name in the user information component of the URI.
     */
    private $UserName = '';


    /**
     * Convert the location to a URL string.
     *
     * @param void
     *
     * @return string
     *   Returns the current location as a string.
     *
     * @uses \StoreCore\Location::get()
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Get the current location.
     *
     * @param void
     *
     * @return string
     *   Returns the location as an URI string.
     */
    public function get()
    {
        $uri = $this->getScheme();
        if (!empty($uri)) {
            $uri .= '://';
        }

        $uri .= $this->getAuthority();

        if (empty($uri)) {
            $uri = $this->getPath();
        } else {
            $uri .= '/' . ltrim($this->getPath(), '/');
        }

        if (!empty($this->getQuery())) {
            $uri .= '?' . $this->getQuery();
        }

        if (!empty($this->getFragment())) {
            $uri .= '#' . $this->getFragment();
        }

        return $uri;
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @param void
     *
     * @return string
     *   Returns the `[user-info@]host[:port]` authority component or an empty
     *   string if no authority information is present.
     *
     * @uses getHost()
     * @uses getPort()
     * @uses getUserInfo()
     */
    public function getAuthority()
    {
        $authority = $this->getHost();
        if (empty($authority)) {
            return (string)null;
        }

        if (!empty($this->getUserInfo())) {
            $authority = $this->getUserInfo() . '@' . $authority;
        }

        if (!empty($this->getPort())) {
            $authority = $authority . ':' . $this->getPort();
        }

        return $authority;
    }

    /**
     * Retrieve the fragment component of the URI.
     *
     * @param void
     *
     * @return string
     *   The URI fragment or an empty string if no fragment is present.
     */
    public function getFragment()
    {
        return $this->Fragment;
    }

    /**
     * Retrieve the host component of the URI.
     *
     * @param void
     *
     * @return string
     *   The URI host in lowercase or an empty if no host is present.
     */
    public function getHost()
    {
        return $this->Host;
    }

    /**
     * Retrieve the path component of the URI.
     *
     * @param void
     *
     * @return string
     *   The URI path.
     */
    public function getPath()
    {
        return $this->Path;
    }

    /**
     * Retrieve the port component of the URI.
     *
     * @param void
     *
     * @return null|int
     *   If a port number is present, and it is non-standard for the current
     *   scheme, this method returns it as an integer.  If the port is the
     *   standard port used with the current scheme, this method returns null.
     */
    public function getPort()
    {
        if ($this->Port === 80 && $this->getScheme() === 'http') {
            return null;
        } elseif ($this->Port === 443 && $this->getScheme() === 'https') {
            return null;
        } else {
            return $this->Port;
        }
    }

    /**
     * Retrieve the query string of the URI.
     *
     * @param void
     *
     * @return string
     *   The URI query string or an empty string if no query string is present.
     */
    public function getQuery()
    {
        return $this->Query;
    }

    /**
     * Get the scheme component of the URI.
     *
     * @param void
     *
     * @return string
     *   The URI scheme normalized to lowercase.  If no scheme is present, this
     *   method returns an empty string.
     */
    public function getScheme()
    {
        return $this->Scheme;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * @param void
     *
     * @return string
     *   Returns the URI user information with a username and an optional
     *   password as a string in `username[:password]` format.  This method
     *   will return an empty string if there is no user information present.
     */
    public function getUserInfo()
    {
        $user_info = $this->UserName;
        if ($this->Password !== null) {
            $user_info .= ':' . $this->Password;
        }
        return $user_info;
    }

    /**
     * Set the authority component of the URI.
     *
     * @param string $authority
     *   URI authority as a string in `[user-info@]host[:port]` format.
     *
     * @return void
     *
     * @uses setHost()
     *   Sets the `host` component.
     * 
     * @uses setPort()
     *   Sets the optional `[:port]` component if it is present.
     *
     * @uses setUserInfo()
     *   Sets the optional `[user-info@]` component if it is present.
     */
    public function setAuthority($authority)
    {
        $authority = trim($authority);

        if (strpos($authority, '@') !== false) {
            $authority = explode('@', $authority, 2);
            $user_info = $authority[0];
            $authority = $authority[1];
            if (!empty($user_info)) {
                $this->setUserInfo($user_info);
            }
        }

        if (strpos($authority, ':') !== false) {
            $authority = explode(':', $authority, 2);
            $authority = $authority[0];
            $port = $authority[1];
            if (is_numeric($port)) {
                $port = (int)$port;
                $this->setPort($port);
            }
        }

        $this->setHost($authority);
    }

    /**
     * Set the fragment component of the URI.
     *
     * @param string $fragment
     *   The URI fragment or an empty string to remove an existing fragment.
     *
     * @return void
     */
    public function setFragment($fragment)
    {
        $fragment = trim($fragment);
        $fragment = ltrim($fragment, '#');
        $this->Fragment = $fragment;
    }

    /**
     * Set the host component of the URI.
     *
     * @param string $host
     *   The URI host.
     *
     * @return void
     */
    public function setHost($host)
    {
        $host = trim($host);
        $host = strtolower($host);
        $this->Host = $host;
    }

    /**
     * Set the URI path.
     *
     * @param string $path
     *   An empty, absolute, or relative HTTP path.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an SPL invalid argument exception for invalid paths.
     */
    public function setPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException();
        }

        $path = trim($path);
        $this->Path = $path;
    }

    /**
     * Set the port number.
     *
     * @param null|int $port
     *   The port number as an integer.  A null value or empty string removes
     *   the port information.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception on an invalid port number.
     */
    public function setPort($port)
    {
        if (empty($port)) {
            return $this->unsetPort();
        } else {
            $this->Port = (int)$port;
        }
    }

    /**
     * Set the query string part of the URI.
     *
     * @param string $query
     *   The URI query string or an empty string to remove an existing query.
     *   A trailing question mark ? is removed.
     *
     * @return void
     */
    public function setQuery($query)
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException();
        }

        $query = trim($query);
        $query = ltrim($query, '?');
        $this->Query = $query;
    }

    /**
     * Set the URI scheme.
     *
     * @param string $scheme
     *   The scheme component of the URI.
     *
     * @return void
     */
    public function setScheme($scheme)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException();
        }

        $scheme = mb_strtolower($scheme, 'UTF-8');
        $this->Scheme = $scheme;
    }

    /**
     * Set the user information component of the URI.
     *
     * @param string $user
     *   User name or an empty string to remove the user information.
     *
     * @param string|null $password
     *   Optional password for `$user`.
     *
     * @return void
     */
    public function setUserInfo($user, $password = null)
    {
        $this->UserName = trim($user);
        if (empty($this->UserName)) {
            $this->Password = null;
        } elseif ($password !== null) {
            $password = trim($password);
            if (empty($password)) {
                $this->Password = null;
            } else {
                $this->Password = $password;
            }
        }
    }

    /**
     * Remove the port.
     *
     * @param void
     * @return void
     */
    public function unsetPort()
    {
        $this->Port = null;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $location = clone $this;
        $location->setFragment($fragment);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $location = clone $this;
        $location->setHost($fragment);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $location = clone $this;
        $location->setPath($path);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $location = clone $this;
        $location->setPort($port);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $location = clone $this;
        $location->setQuery($query);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        $location = clone $this;
        $location->setScheme($scheme);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $location = clone $this;
        $user_info = trim($user);
        if (!empty($user_info) && $password !== null) {
            $user_info .= ':' . $password;
        }
        $location->setUserInfo($user_info);
        return $location;
    }


    /**
     * @testdox Location::withUserInfo() exists
     */
    public function testLocationWithUserInfoExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withUserInfo'));
    }

    /**
     * @depends testLocationWithUserInfoExists
     * @testdox Location::withUserInfo() is public
     */
    public function testLocationWithUserInfoIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withUserInfo');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithUserInfoExists
     * @testdox Location::withUserInfo() has two parameters
     */
    public function testLocationWithUserInfoHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withUserInfo');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testLocationWithUserInfoExists
     * @testdox Location::withUserInfo() has one required parameter
     */
    public function testLocationWithUserInfoHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withUserInfo');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
