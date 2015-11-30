<?php
namespace StoreCore\Types;

/**
 * Form Token
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class FormToken
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
        $token = (string)null;
        for ($i = 1; $i <= 512; $i++) {
            $token .= $characters[mt_rand(0, 61)];
        }
        return $token;
    }
}
