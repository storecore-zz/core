<?php
namespace StoreCore\StoreFront;

/**
 * Web Page Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Catalog
 * @version   0.1.0-alpha.1
 */
class FullPageCache extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * Silently read and publish a web page from the web cache.
     *
     * @param void
     *
     * @return bool
     *   Returns true on a cache hit or false on a cache miss.
     */
    public function trigger()
    {
        $location = new \StoreCore\StoreFront\Location($this->Registry);
        $key = new \StoreCore\Types\CacheKey($location->get());
        $cache = new \StoreCore\FileSystem\FileCacheReader();

        // Cache miss
        if ($cache->exists($key) === false) {
            return false;
        }
        unset($location, $key);

        $response = new \StoreCore\Response($this->Registry);
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
