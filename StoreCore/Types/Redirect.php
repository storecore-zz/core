<?php
namespace StoreCore\Types;

/**
 * Cacheable HTTP Redirect
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Redirect extends \Psr\Cache\AbstractCacheItem implements \Psr\Cache\CacheItemInterface
{
    const VERSION = '0.1.0';

    /**
     * @var string $RedirectFromURL
     * @var string $RedirectToURL
     */
    private $RedirectFromURL;
    private $RedirectToURL;

    /**
     * @param string|null $from_url
     * @param string $to_url
     * @return void
     */
    public function __construct($from_url = null, $to_url = '/')
    {
        if ($from_url !== null) {
            $this->set(array($from_url => $to_url));
        }

        // Default expiration is "access plus 1 year".
        $this->expiresAfter(new \DateInterval('P1Y'));
    }

    /**
     * @param void
     * @return array
     */
    public function get()
    {
        return array($RedirectFromURL => $RedirectToURL);
    }

    /**
     * Permanent redirect.
     *
     * @param void
     * @return void
     */
    public function redirect()
    {
        // Cache publicly for 1 year (the HTTP maximum).
        if ($this->ExpiresAt === null) {
            header('Cache-Control: max-age=31536000, public', true);
        }

        header('Location: ' . $this->RedirectToURL, true, 301);
        exit();
    }

    /**
     * @param array $value
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
     * @uses \StoreCore\Types\CacheKey
     */
    public function set($value)
    {
        if (!is_array($value)) {
            throw new \Psr\Cache\InvalidArgumentException();
        }

        foreach ($value as $from_url => $to_url) {
            if (!is_string($from_url) || !is_string($to_url)) {
                throw new \Psr\Cache\InvalidArgumentException();
            }
        }

        $from_url = mb_strtolower($from_url, 'UTF-8');
        $this->RedirectFromURL = $from_url;
        $this->RedirectToURL = $to_url;

        $cache_key = new \StoreCore\Types\CacheKey($from_url);
        $this->Key = (string)$cache_key;
    }
}
