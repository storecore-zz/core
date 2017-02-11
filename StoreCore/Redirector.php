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
 * @copyright Copyright © 2016-2017 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Redirector
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Find and execute a 301 Moved Permanently redirect.
     *
     * The static find() method looks for a cacheable redirected URL like
     * `//www.example.com/foo/bar-baz` without a protocol prefix.  It then
     * silently executes an HTTP 301 permanent redirect if a match is found in
     * the redirects cache pool.  The static method is completely silent: it
     * simply either executes a permanent redirect or it does not, without any
     * return value or exception.
     *
     * @param \StoreCore\Request $request
     * @return void
     * @uses \StoreCore\Request::getHostName()
     * @uses \StoreCore\Request::getRequestPath()
     * @uses \StoreCore\Types\CacheKey
     * @uses \StoreCore\FileSystem\Redirects
     */
    public static function find(\StoreCore\Request $request)
    {
        $url = $request->getHostName() . $request->getRequestPath();
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
