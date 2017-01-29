<?php
namespace StoreCore\Types;

/**
 * Form Token
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class FormToken implements \StoreCore\SingletonInterface
{
    const VERSION = '0.1.0';

    /**
     * Get a random ASCII token.
     *
     * @param void
     * @return string
     */
    public static function getInstance()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwzyzABCDEFGHIJKLMNOPQRSTUVWZYZ';
        $characters = str_shuffle($characters);
        $token = (string)null;
        for ($i = 1; $i <= 512; $i++) {
            $token .= substr($characters, mt_rand(0, 61), 1);
        }
        return $token;
    }
}
