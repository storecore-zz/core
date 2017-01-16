<?php
namespace StoreCore\Types;

/**
 * International Article Number
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2016-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\OML
 * @version   0.1.0
 */
class InternationalArticleNumber extends Varchar implements TypeInterface, ValidateInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @param string|int $initial_value
     * @param bool $strict
     * @return void
     */
    public function __construct($initial_value, $strict = true)
    {
        if (is_int($initial_value)) {
            $initial_value = (string)$initial_value;
        } elseif (!ctype_digit($initial_value)) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($initial_value, $strict);

        $strlen = strlen($this->Value);
        if ($strlen > 13) {
            throw new \DomainException();
        } elseif ($strlen == 13) {
            if ((int)substr($this->Value, -1) !== $this->getCheckDigit(substr($this->Value, 0, 12))) {
                throw new \InvalidArgumentException();
            }
        } elseif ($strlen == 12) {
            $this->Value .= $this->getCheckDigit($this->Value);
        } elseif (!$strict) {
            if ($this->Value === '0') {
                $this->Value = (string)mt_rand(200, 299);
            }
            $this->Value .= str_pad(mt_rand(1, 999999999), 12 - strlen($this->Value), '0');
            $this->Value .= $this->getCheckDigit($this->Value);
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * @param string|null $number
     * @return int
     */
    public function getCheckDigit($number = null)
    {
        if ($number === null) {
            return (int)substr($this->Value, -1);
        }

        if (strlen($number) == 13) {
            return (int)substr($number, -1);
        } else {
            $weight_flag = true;
            $sum = 0;
            for ($i = strlen($number) - 1; $i >= 0; $i--) {
                $sum += (int)$number[$i] * ($weight_flag ? 3 : 1);
                $weight_flag = !$weight_flag;
            }
            return (10 - ($sum % 10)) % 10;
        }
    }

    /**
     * Get the next EAN-13 article number.
     *
     * @param void
     * @return \StoreCore\Types\InternationalArticleNumber
     * @throws \RangeException
     */
    public function getNextNumber()
    {
        $prefix = substr($this->Value, 0, 7);
        $current_number = (int)substr($this->Value, 7, 5);

        if ($current_number === 99999) {
            throw new \RangeException();
        }

        $next_number = $current_number + 1;
        $next_number = sprintf('%05d', $next_number);
        return new InternationalArticleNumber($prefix . $next_number);
    }

    /**
     * Generate a random EAN-13 article number.
     *
     * @param string|int|null $prefix
     * @return \StoreCore\Types\InternationalArticleNumber
     */
    public static function getRandomNumber($prefix = null)
    {
        if ($prefix === null) {
            $prefix = 0;
        }
        return new InternationalArticleNumber($prefix, false);
    }

    /**
     * Validate an EAN-13 article number.
     *
     * @param mixed $variable
     * @return bool
     */
    public static function validate($variable)
    {
        try {
            $ean = new InternationalArticleNumber($variable);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
