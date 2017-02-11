<?php
namespace StoreCore;

/**
 * Full-Page Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class FullPageCache
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Find a cached webpage.
     *
     * @param \StoreCore\Registry $registry
     * @return void
     * @uses \StoreCore\Request::getMethod()
     * @uses \StoreCore\Request::getHostName()
     * @uses \StoreCore\Request::getRequestPath()
     * @uses \StoreCore\Types\CacheKey
     */
    public static function find(Registry $registry)
    {
        // Only cache GET and HEAD requests.
        if (
            $registry->get('Request')->getMethod() !== 'GET'
            && $registry->get('Request')->getMethod() !== 'HEAD'
        ) {
            return;
        }

        // Find the cached pages directory.
        if (!defined('STORECORE_FILESYSTEM_CACHE_PAGES_DIR')) {
            if (defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
                $dir = STORECORE_FILESYSTEM_CACHE_DIR . 'pages';
            } else {
                $dir = realpath(__DIR__ . '/../cache/pages');
            }
            if (is_dir($dir)) {
                define('STORECORE_FILESYSTEM_CACHE_PAGES_DIR', $dir . DIRECTORY_SEPARATOR);
            }
            unset($dir);
        }

        // Generate a cache key.
        $cache_key = new \StoreCore\Types\CacheKey(
            $registry->get('Request')->getHostName()
            . $registry->get('Request')->getRequestPath()
        );


        // Find the cache file.
        $filename = STORECORE_FILESYSTEM_CACHE_PAGES_DIR . $cache_key . '.tmp';
        if (!is_file($filename)) {
            return;
        }

        // Last-modified timestamp and entity tag
        $last_modified = filemtime($filename);
        $etag = md5_file($filename, true);
        $etag = base64_encode($etag);
        $etag = rtrim($etag, '=');

        // Create response headers.
        ob_start('ob_gzhandler', true);
        header('Cache-Control: public', true);
        header('Content-Type: text/html', true);
        header('ETag: "' . $etag . '"', true);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', $last_modified), true);
        header('Pragma: cache', true);
        header('X-Powered-By: StoreCore/' . STORECORE_VERSION, true);

        if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            $http_if_none_match = strip_tags($_SERVER['HTTP_IF_NONE_MATCH']);
            $http_if_none_match = trim($http_if_none_match);
            $http_if_none_match = trim($http_if_none_match, '"');
        } else {
            $http_if_none_match = false;
        }

        if (
            isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])
            && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified || $http_if_none_match == $etag)
        ) {
            header('HTTP/1.1 304 Not Modified', true);
        } else {
            readfile($filename);
        }
        exit;
    }
}
