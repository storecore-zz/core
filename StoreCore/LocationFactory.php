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

        $location = new Location($uri);

        $lowercase_uri = mb_strtolower($uri, 'UTF-8');

        if (substr($lowercase_uri, 0, 8) === 'https://') {
            $location->setScheme('https');
        } elseif (substr($lowercase_uri, 0, 7) === 'http://') {
            $location->setScheme('http');
        }

        return $location;
    }

    /**
     * Create a location data object for the current location.
     *
     * @param void
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public static function getCurrentLocation()
    {
        $factory = new LocationFactory();
        $location = $factory->createUri($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

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
