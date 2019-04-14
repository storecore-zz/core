<?php
namespace StoreCore\Types;

/**
 * Cache Key
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class CacheKey implements StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /** @var string $Key */
    private $Key = '';

    /**
     * @param string $str
     *   Optional case-insensitive string.  If this parameter is not set,
     *   a random unique identifier (UID) is generated.
     *
     * @return self
     */
    public function __construct($str = null)
    {
        if ($str === null) {
            $str = uniqid(mt_rand(), true);
        }
        $this->set($str);
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Get the cache key.
     *
     * @param void
     *
     * @return string
     *   Returns a string containing the cache key as lowercase hexits.
     */
    public function get()
    {
        return $this->Key;
    }

    /**
     * Derive the cache key from a string.
     *
     * @param string $str
     *   Case-insensitive string to convert to a cache key.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$str` parameter is not
     *   a string or an empty string.
     */
    public function set($str)
    {
        if (!is_string($str) || empty($str)) {
            throw new \InvalidArgumentException();
        }
        $str = mb_strtolower($str, 'UTF-8');
        $str = hash('sha256', $str);
        $this->Key = $str;
    }
}
