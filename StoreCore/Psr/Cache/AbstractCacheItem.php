<?php
namespace Psr\Cache;

/**
 * Abstract implementation of the cache item interface.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-6-cache.md
 * @version   0.2.0
 */
abstract class AbstractCacheItem implements CacheItemInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.2.0';

    /**
     * @var \DateInterval|null $ExpiresAfter
     * @var \DateTime|null     $ExpiresAt
     * @var bool               $IsHit
     * @var string             $Key
     */
    protected $ExpiresAfter;
    protected $ExpiresAt;
    protected $IsHit = false;
    protected $Key = '';

    /**
     * @inheritDoc
     */
    public function expiresAfter($time)
    {
        if (is_int($time)) {
            // Handle integers as a time period in seconds.
            $this->ExpiresAfter = new \DateInterval('PT' . $time . 'S');
        } elseif ($time instanceof \DateInterval) {
            $this->ExpiresAfter = $time;
        } else {
            throw new InvalidArgumentException();
        }

        date_default_timezone_set('UTC');
        $this->ExpiresAt = new \DateTime();
        $this->ExpiresAt->add($this->ExpiresAfter);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function expiresAt($expiration)
    {
        if ($expiration instanceof \DateTime) {
            $this->ExpiresAfter = null;
            $this->ExpiresAt = $expiration;
        }
        return $this;
    }

    /**
     * Get the key for the current cache item.
     *
     * @param void
     *
     * @return string
     *   Returns the cache key as a string and an empty string if the cache item
     *   has no cache key.
     */
    public function getKey()
    {
        return $this->Key;
    }

    /**
     * Confirms if the cache item lookup resulted in a cache hit.
     *
     * @param void
     *
     * @return bool
     *   Returns true on a cache hit, otherwise false.
     */
    public function isHit()
    {
        return $this->IsHit;
    }
}
