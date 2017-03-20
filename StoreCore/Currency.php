<?php
namespace StoreCore;

/**
 * Currency Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Currency
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string $CurrencyCode
     *   ISO 4217 currency code.  Defaults to 'EUR' for the European euro.
     */
    private $CurrencyCode = 'EUR';

    /**
     * @var int $CurrencyID
     *   ISO 4217 currency number.  Defaults to 978 for the European euro.
     */
    private $CurrencyID = 978;

    /**
     * @var string $CurrencySymbol
     *   Currency sign.  Defaults to '€' for the euro sign.
     */
    private $CurrencySymbol = '€';

    /**
     * @var int $NumberOfDigits
     *   Number of digits for cents et cetera. Defaults to 2.
     */
    private $NumberOfDigits = 2;

    /**
     * Get the alphanumeric currency code.
     *
     * @param void
     *
     * @return int
     *   Returns the ISO 4217 currency code as a string.
     */
    public function getCurrencyCode()
    {
        return $this->CurrencyCode;
    }

    /**
     * Get the currency identifier.
     *
     * @param void
     *
     * @return int
     *   Returns the numeric ICO 4217 currency code as an integer.
     */
    public function getCurrencyID()
    {
        return $this->CurrencyID;
    }

    /**
     * Get the currency sign.
     *
     * @param void
     *
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->CurrencySymbol;
    }

    /**
     * Get the number of digits for amounts.
     *
     * @param void
     * @return int
     */
    public function getPrecision()
    {
        return $this->NumberOfDigits;
    }

    /**
     * Set the currency code.
     *
     * @param string $iso_currency_code
     *   Three-letter alphanumeric ISO 4217 currency code.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws a Standard PHP Library (SPL) invalid argument logic exception
     *   if the currency code is not a string consisting of three characters.
     */
    public function setCurrencyCode($iso_currency_code)
    {
        if (!is_string($iso_currency_code)) {
            throw new \InvalidArgumentException();
        }

        $iso_currency_code = trim($iso_currency_code);
        if (strlen($iso_currency_code) !== 3) {
            throw new \InvalidArgumentException();
        }

        $iso_currency_code = strtoupper($iso_currency_code);
        $this->CurrencyCode = $iso_currency_code;
        return $this;
    }

    /**
     * Set the currency identifier.
     *
     * @param int|string $iso_currency_number
     *   ISO 4217 currency number as an integer or a three-digit numeric
     *   string.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the currency identifier
     *   is not an integer or could not be converted to an integer.
     */
    public function setCurrencyID($iso_currency_number)
    {
        if (is_string($iso_currency_number)) {
            $iso_currency_number = intval($iso_currency_number);
        }

        if (!is_int($iso_currency_number)) {
            throw new \InvalidArgumentException();
        }

        $this->CurrencyID = $iso_currency_number;
        return $this;
    }

    /**
     * Set the currency sign.
     *
     * @param string $currency_sign
     *   A single character or short string for a currency symbol.  If this
     *   optional parameter is omitted, the universal currency symbol '¤' is
     *   used.
     *
     * @return $this
     */
    public function setCurrencySymbol($currency_sign = '¤')
    {
        $this->CurrencySymbol = $currency_sign;
        return $this;
    }

    /**
     * Set the number of digits in amounts.
     *
     * @param int $NumberOfDigits
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic expection if the supplied parameter
     *   is not an integer.
     *
     * @throws \DomainException
     *   Throws a domain expection if the supplied number of digits is negative
     *   or greater than 4.
     */
    public function setPrecision($number_of_digits)
    {
        if (!is_int($number_of_digits)) {
            throw new \InvalidArgumentException();
        } elseif ($number_of_digits < 0 || $number_of_digits > 4) {
            throw new \DomainException();
        }
        $this->NumberOfDigits = $number_of_digits;
        return $this;
    }
}
