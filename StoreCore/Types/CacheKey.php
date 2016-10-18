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
     *   Case-insensitive string.
     */
    public function __construct($str)
    {
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
     * @param void
     * @return string
     */
    public function get()
    {
        return $this->Key;
    }

    /**
     * @param string $str
     * @return void
     * @throws \InvalidArgumentException
     */
    private function set($str)
    {
        if (!is_string($str) || empty($str)) {
            throw new \InvalidArgumentException(
                'Argument 1 passed to ' . __METHOD__ . '() must be of the type string, ' . gettype($str) . ' given'
            );
        }

        $str = mb_strtolower($str, 'UTF-8');

        if (filter_var($str, FILTER_VALIDATE_URL) !== false) {
            $str = urldecode($str);
            $str = str_ireplace('https://', null, $str);
            $str = str_ireplace('http://',  null, $str);
            $str = '//' . ltrim($str, '/');
        }

        $this->Key = sha1($str);
    }
}
