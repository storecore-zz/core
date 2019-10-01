<?php
namespace StoreCore\FileSystem;

use StoreCore\AbstractController;
use StoreCore\LocationFactory;
use StoreCore\ResponseFactory;

use StoreCore\FileSystem\FileCacheReader;

use StoreCore\Types\CacheKey;

/**
 * Full-Page Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Catalog
 * @version   0.1.0
 */
class FullPageCache extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Silently read and publish a web page from the web cache.
     *
     * @param void
     *
     * @return bool
     *   Returns true on a cache hit or false on a cache miss.
     */
    public static function trigger()
    {
        try {
            $location = LocationFactory::getCurrentLocation();
        } catch (\RuntimeException $e) {
            return false;
        }

        $key = new CacheKey($location->get());
        $cache = new FileCacheReader();

        // Cache miss
        if ($cache->exists($key) === false) {
            return false;
        }
        unset($location, $key);

        $factory = new ResponseFactory();
        $response = $factory->createResponse();
        $cache_file_contents = $cache->read();

        // Set expiration headers
        $last_modified = $cache->getFileModificationTimestamp();
        $etag = md5($cache_file_contents);
        $response->addHeader('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_modified) . ' GMT');
        $response->addHeader('Expires: ' . gmdate('D, d M Y H:i:s', time() + 60480) . ' GMT');
        $response->addHeader('Etag: ' . $etag);

        // Handle HTTP HEAD requests
        if ($this->Request->getMethod() === 'HEAD') {
            $response->output();
            return true;
        }

        // Handle client caching
        $http_if_none_match = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            if (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified || $http_if_none_match == $etag) {
                $response->addHeader('HTTP/1.1 304 Not Modified');
                $response->output();
                return true;
            }
        }

        $response->setResponseBody($cache_file_contents);
        $response->output();
        return true;
    }
}
