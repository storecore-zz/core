<?php
namespace StoreCore\Types;

use StoreCore\Types\CacheKey;

use Psr\Cache\AbstractCacheItem;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Cacheable HTTP Redirect
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Redirect extends AbstractCacheItem implements CacheItemInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string $RedirectFromURL
     *   Origin URL to redirect from.
     */
    private $RedirectFromURL;

    /**
     * @var string $RedirectToURL
     *   Destination URL to redirect to.
     */
    private $RedirectToURL;

    /**
     * Create a redirect.
     *
     * @param string|null $from_url
     *   Origin URL to redirect from.
     *
     * @param string $to_url
     *   Destination URL to redirect to.
     *
     * @return self
     */
    public function __construct($from_url = null, $to_url = '/')
    {
        if ($from_url !== null) {
            $this->set(array($from_url => $to_url));
        }
     }

    /**
     * Get the redirect URLs.
     * 
     * @param void
     *
     * @return array
     *   Returns a URL key/value pair with the origin URL as the key and the
     *   destination URL as the value.
     */
    public function get()
    {
        return array($RedirectFromURL => $RedirectToURL);
    }

    /**
     * Execute a permanent redirect.
     *
     * @param void
     * @return void
     */
    public function redirect()
    {
        // Cache publicly for 1 year (the HTTP maximum).
        if ($this->ExpiresAt === null && $this->ExpiresAfter === null) {
            header('Cache-Control: public, max-age=31536000', true);
        }

        header('Location: ' . $this->RedirectToURL, true, 301);
        header('X-Powered-By: StoreCore', true);
        exit(0);
    }

    /**
     * Set the redirect URLs.
     *
     * @param array $value
     *   Redirect URLs as a key/value pair.
     *
     * @return $this
     *
     * @throws \Psr\Cache\InvalidArgumentException
     *   Throws a PSR 6 Cache invalid argument cache exception if the `$value`
     *   is not an array or the array does not consist of a pair of strings.
     *
     * @uses \StoreCore\Types\CacheKey
     *   The StoreCore CacheKey type class is used to generate a cache key
     *   that is derived from the source URL.  The cache key is case-insensitive
     *   and ignores the protocol prefix in de source URL.
     */
    public function set($value)
    {
        if (!\is_array($value)) {
            throw new InvalidArgumentException();
        }

        if (\count($value) !== 1) {
            throw new InvalidArgumentException();
        }

        foreach ($value as $from_url => $to_url) {
            if (!\is_string($from_url) || empty($from_url)) {
                throw new InvalidArgumentException();
            }

            if (!\is_string($to_url) || empty($to_url)) {
                throw new InvalidArgumentException();
            }
        }

        $from_url = mb_strtolower($from_url, 'UTF-8');
        $this->RedirectFromURL = $from_url;
        $this->RedirectToURL = $to_url;

        $cache_key = new CacheKey($from_url);
        $this->Key = (string) $cache_key;

        return $this;
    }
}
