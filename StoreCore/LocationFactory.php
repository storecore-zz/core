<?php
namespace StoreCore;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use StoreCore\Location;

/**
 * Location Factory
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-17-http-factory.md
 *      PSR-17: HTTP Factories
 *
 * @see https://www.php-fig.org/psr/psr-17/
 *      PSR-17: HTTP Factories
 */
class LocationFactory implements UriFactoryInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Create a new URI.
     *
     * Creates PSR-7 UriInterface objects from URL strings by parsing the format:
     * 
     *     scheme :// authority / path ? query # fragment
     * 
     * where authority is:
     *
     *     scheme :// [user-info@]host[:port] / path ? query # fragment
     *
     * @param string $uri
     *   The URI to parse.
     *
     * @return \Psr\Http\Message\UriInterface
     *   Instance of a PSR-7 Uniform Resource Identifier (URI).
     *
     * @throws \InvalidArgumentException
     *   If the given URI cannot be parsed.
     */
    public function createUri($uri = '')
    {
        if (!is_string($uri)) {
            throw new \InvalidArgumentException();
        }

        $uri = trim($uri);
        if (empty($uri)) {
            throw new \InvalidArgumentException();
        }

        $uri = parse_url($uri);
        if ($uri === false) {
            throw new \InvalidArgumentException(); 
        }

        $location = new Location();

        // Scheme
        if (isset($uri['scheme'])) {
            $location->setScheme($uri['scheme']);
        }

        // Username and password
        if (isset($uri['user'])) {
            if (isset($uri['pass'])) {
                $location->setUserInfo($uri['user'], $uri['pass']);
            } else {
                $location->setUserInfo($uri['user']);
            }
        }

        // Host
        if (isset($uri['host'])) {
            $location->setHost($uri['host']);
        } elseif (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
            $location->setHost(strtolower($_SERVER['HTTP_HOST']));
        }

        // Path
        if (isset($uri['path'])) {
            $location->setPath($uri['path']);
        }

        // Query string
        if (isset($uri['query'])) {
            $location->setQuery($uri['query']);
        }

        // Bookmark fragment
        if (isset($uri['fragment'])) {
            $location->setFragment($uri['fragment']);
        }

        return $location;
    }

    /**
     * Create a location data object for the current request.
     *
     * @param void
     *
     * @return \Psr\Http\Message\UriInterface
     *   Instance of a PSR-7 Uniform Resource Identifier (URI).
     *
     * @throws \RuntimeException
     *   This method creates a `Location` object with a `UriInterface` by
     *   parsing `$_SERVER` parameters and therefore throws a runtime exception
     *   if `$_SERVER` is not set or is empty.
     */
    public static function getCurrentLocation()
    {
        if (!isset($_SERVER) || empty($_SERVER)) {
            throw new \RuntimeException();
        }

        $location = new Location();

        if (
            isset($_SERVER['HTTP_HOST'])
            && !empty($_SERVER['HTTP_HOST']) 
            && isset($_SERVER['REQUEST_URI'])
        ) {
            try {
                $factory = new LocationFactory();
                $location = $factory->createUri($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            } catch (\Exception $e) {
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        } else {
            throw new \RuntimeException();
        }

        if (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443
        ) {
            $location->setScheme('https');
        } else {
            $location->setScheme('http');
        }

        if (isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT'])) {
            $location->setPort($_SERVER['SERVER_PORT']);
        }

        return $location;
    }
}
