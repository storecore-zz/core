<?php
namespace StoreCore\Types;

/**
 * Cache Key
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class CacheKey
{
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
     * @return string
     */
    public function get()
    {
        return $this->Key;
    }

    /**
     * Derive the cache key from a string.
     *
     * @param string $str
     * @return void
     * @throws \InvalidArgumentException
     */
    public function set($str)
    {
        if (!is_string($str) || empty($str)) {
            throw new \InvalidArgumentException();
        }
        $str = mb_strtolower($str, 'UTF-8');
        $str = md5($str);
        $this->Key = $str;
    }
}
