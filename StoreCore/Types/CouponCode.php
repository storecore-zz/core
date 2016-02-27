<?php
namespace StoreCore\Types;

/**
 * Coupon Code
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class CouponCode
{
    /**
     * @var string CHARACTER_SET
     *   Character set without the digits 0 and 1, and the letters A, E, I, O,
     *   and U.  These digits and letters are omitted to improve readability,
     *   limit the number of human input errors, and prevent foul language.
     */
    const CHARACTER_SET = '23456789BCDFGHJKLMNPQRSTVWXYZ';

    const VERSION = '0.1.0-alpha.1';

    /**
     * @var string $CouponCode
     */
    private $CouponCode = null;

    /**
     * @var string $StringSeparator
     */
    private $StringSeparator = ' ';

    /**
     * @param string|null $coupon_code
     * @return void
     */
    public function __construct($coupon_code = null, $string_separator = null)
    {
        if ($coupon_code !== null) {
            $this->setCode($coupon_code);
        }
    }

    /**
     * Generate a random coupon code.
     *
     * @param void
     * @return void
     */
    public function randomize()
    {
        $code = (string)null;
        do {
            $code .= substr(self::CHARACTER_SET, mt_rand(0, 28), 1);
        } while (strlen($code) < 12);
        $this->setCode($code);
    }

    /**
     * Get the coupon code as a numeric string.
     *
     * @param void
     *
     * @return string
     *   Returns a number between 270764647904092404 (coupon code 2222 2222 2222)
     *   and 4738381338321617846 (coupon code ZZZZ ZZZZ ZZZZ) as a string.
     *   This numeric representation of the coupon code allows for bar code
     *   printing on coupons, vouchers, gift cards, receipts, and invoices.
     */
    public function getNumber()
    {
        if ($this->CouponCode === null) {
            $this->randomize();
        }
        return base_convert($this->CouponCode, 36, 10);
    }

    /**
     * Get the coupon code as a string.
     *
     * @param void
     * @return string
     */
    public function getString()
    {
        if ($this->CouponCode === null) {
            $this->randomize();
        }
        return implode($this->StringSeparator, str_split($this->CouponCode, 4));
    }

    /**
     * Set the coupon code.
     *
     * @param string $coupon_code
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   A Standard PHP Library (SPL) invalid argument exception is thrown if
     *   the $coupon_code parameter is not a string.
     *
     * @throws \LengthException
     *   An SPL length exception is thrown if the $coupon_code string parameter
     *   does not have a string length of 12 characters.
     *
     * @throws \UnexpectedValueException
     *   An SPL unexpected value runtime exception is thrown if the coupon code
     *   contains one or more illegal characters.  This exception MAY be used
     *   as a partial validation of coupon codes and is therefore implemented
     *   as a runtime exception.
     */
    public function setCode($coupon_code)
    {
        if (!is_string($coupon_code)) {
            throw new \InvalidArgumentException(
                'Argument 1 passed to ' . __METHOD__ . '() must be of the type string, ' . gettype($coupon_code) . ' given'
            );
        }

        $coupon_code = trim($coupon_code);
        $coupon_code = str_ireplace(' ', null, $coupon_code);
        $coupon_code = str_ireplace('-', null, $coupon_code);
        if (strlen($coupon_code) !== 12) {
            throw new \LengthException(
                __METHOD__ . '() expects argument 1 to be a string of 12 characters'
            );
        }

        $coupon_code = strtoupper($coupon_code);
        if (!ctype_alnum($coupon_code)) {
            throw new \UnexpectedValueException(
                'The coupon code passed to ' . __METHOD__ . '() contains one or more illegal characters'
            );
        } else {
            $characters = str_split($coupon_code, 1);
            foreach ($characters as $character) {
                if (strpos(self::CHARACTER_SET, $character) === false) {
                    throw new \UnexpectedValueException(
                        'The coupon code passed to ' . __METHOD__ . '() contains an illegal character: ' . $character
                    );
                }
            }
        }

        $this->CouponCode = $coupon_code;
    }

    /**
     * Set the group separator for the coupon code string.
     *
     * @param string|bool $string_separator
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setStringSeparator($string_separator)
    {
        if ($string_separator === false) {
            $string_separator = '';
        } elseif ($string_separator === true) {
            $string_separator = ' ';
        } elseif (!is_string($coupon_code)) {
            throw new \InvalidArgumentException(
                'Argument 1 passed to ' . __METHOD__ . '() must be of the type string or bool, ' . gettype($coupon_code) . ' given'
            );
        }

        $this->StringSeparator = $string_separator;
    }
}
