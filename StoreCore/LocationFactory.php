<?php
namespace StoreCore;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use StoreCore\Location;

/**
 * Location Factory.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
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
     *    scheme :// [user-info@]host[:port] / path ? query # fragment
     *
     * @param string $uri
     *   The URI to parse.
     *
     * @return \Psr\Http\Message\UriInterface
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

        $location = new Location();

        // Scheme
        if (strpos($uri, '://') !== false) {
            $uri = explode('://', $uri, 2);
            $location->setScheme($uri[0]);
            $uri = $uri[1];
        }

        // Authority
        if (strpos($uri, '/') !== false) {
            $uri = explode('/', $uri, 2);
            $location->setAuthority($uri[0]);
            $uri = $uri[1];
        }

        // Path
        if (strpos($uri, '?') !== false) {
            $uri = explode('?', $uri, 2);
            $location->setPath($uri[0]);
            $uri = $uri[1];
        }

        // Query string and fragment, if any
        if (!empty($uri)) {
            if (strpos($uri, '#') !== false) {
                $uri = explode('#', $uri, 2);
                $location->setQuery($uri[0]);
                $location->setFragment($uri[1]);
            } else {
                $location->setQuery($uri);
            }
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

        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
            $factory = new LocationFactory();
            try {
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

        return $location;
    }
}
