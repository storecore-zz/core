<?php
namespace StoreCore\Types;

/**
 * Cache Key
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class CacheKey
{
    const VERSION = '0.1.0-alpha.1';

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
        if (!is_string($str)) {
            throw new \InvalidArgumentException(
                'Argument 1 passed to ' . __METHOD__ . '() must be of the type string, ' . gettype($str) . ' given'
            );
        }

        $str = mb_strtolower($str, 'UTF-8');
        $this->Key = md5($str);
    }
}
