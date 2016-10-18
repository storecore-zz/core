<?php
namespace StoreCore;

/**
 * HTTP Redirection
 *
 * The StoreCore\Redirector class allows for soft permanent redirects.  The
 * static Redirector::find() method looks for a redirect candidate and silently
 * executes a permanent redirect if a redirect destination is found.
 * Redirects are handled through the file system in order to minimize the
 * database load, to bypass the full core services stack, and to allow for
 * manual addition and deletion of redirects by users.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Redirector
{
    const VERSION = '0.1.0';

    /**
     * Find and execute a 301 Moved Permanently redirect.
     *
     * @param void
     * @return void
     * @uses \StoreCore\Types\CacheKey
     * @uses \StoreCore\FileSystem\Redirects
     */
    public static function find()
    {
        if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
            $url = (string)$_SERVER['HTTP_HOST'];
        } else {
            return;
        }

        if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
            $url .= (string)$_SERVER['REQUEST_URI'];
        }

        $url = '//' . ltrim($url, '/');
        $cache_key = new \StoreCore\Types\CacheKey($url);
        $cache_key = (string)$cache_key;
        unset($url);

        $cache_pool = new \StoreCore\FileSystem\Redirects();
        if ($cache_pool->hasItem($cache_key) !== true) {
            return;
        } else {
            $location = $cache_pool->getItem($cache_key);
            $location->redirect();
        }
    }
}
