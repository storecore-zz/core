<?php
namespace StoreCore\Types;

use StoreCore\Types\StringableInterface;
use Psr\Http\Message\UriInterface;

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

    /**
     * @var string $Key
     *   Cache key hash.
     */
    private $Key;

    /**
     * @param string|StringableInterface|UriInterface $str
     *   Optional case-insensitive string.  If this parameter is not set,
     *   a random unique identifier (UID) is generated.
     *
     * @return self
     */
    public function __construct($str = null)
    {
        if ($str !== null) {
            $this->set($str);
        }
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
    private function get()
    {
        if ($this->Key === null) {
            $str = uniqid(bin2hex(openssl_random_pseudo_bytes(20)), true);
            $this->set($str);
        }
        return $this->Key;
    }

    /**
     * Derive the cache key from a string.
     *
     * @param string|StringableInterface|UriInterface $str
     *   Case-insensitive string to convert to a cache key.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$str` parameter is not
     *   a string, cannot be converted to a string, or is an empty string.
     */
    private function set($str)
    {
        if ($str instanceof UriInterface || $str instanceof StringableInterface) {
            $str = (string) $str;
        }

        if (!is_string($str) || empty($str)) {
            throw new \InvalidArgumentException();
        }

        $str = mb_strtolower($str, 'UTF-8');

        // Shorten 'https://' and 'http://' to '//'
        if (substr($str, 0, 8) === 'https://') {
            $str = substr($str, 6);
        } elseif (substr($str, 0, 7) === 'http://') {
            $str = substr($str, 5);
        }

        $str = hash('sha256', $str);
        $this->Key = $str;
    }
}
