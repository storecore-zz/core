<?php
namespace StoreCore\Types;

/**
 * Form Token
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015-2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class FormToken implements \StoreCore\SingletonInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Get a random ASCII token.
     *
     * @param void
     *
     * @return string
     *   Returns a random string consisting of digits (0–9), lowercase ASCII
     *   characters (a–z), and uppercase ASCII characters (A–Z).  The current
     *   default string length is 512 characters but this MAY be changed in
     *   the future.
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
