<?php
namespace StoreCore\Types;

/**
 * Numeric Payment Reference
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\OML
 * @version   0.1.0
 */
 class PaymentReference
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /** @var string $Prefix */
    private $Prefix;

    /** @var string $TransactionID */
    private $TransactionID;

    /**
     * @param int|string $transaction_id
     * @return self
     * @uses setTransactionID()
     */
    public function __construct($transaction_id = null)
    {
        $this->Prefix = gmdate('Ymd');
        if ($transaction_id === null) {
            $transaction_id = mt_rand(1, 9999999);
        }
        $this->setTransactionID($transaction_id);
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        // Add a date prefix.
        $number = $this->Prefix . $this->TransactionID;
        if (strlen($number) > 15) {
            $number = substr($number, -15);
        }

        // Calculate the check digit.
        $sum = 0;
        $sum += substr($number,  -1, 1) *  2;
        $sum += substr($number,  -2, 1) *  4;
        $sum += substr($number,  -3, 1) *  8;
        $sum += substr($number,  -4, 1) *  5;
        $sum += substr($number,  -5, 1) * 10;
        $sum += substr($number,  -6, 1) *  9;
        $sum += substr($number,  -7, 1) *  7;
        $sum += substr($number,  -8, 1) *  3;
        $sum += substr($number,  -9, 1) *  6;
        $sum += substr($number, -10, 1) *  1;
        $sum += substr($number, -11, 1) *  2;
        $sum += substr($number, -12, 1) *  4;
        $sum += substr($number, -13, 1) *  8;
        $sum += substr($number, -14, 1) *  5;
        $sum += substr($number, -15, 1) * 10;
        $check_digit = 11 - ($sum % 11);

        // Check digit 10 becomes 1 and 11 becomes 0.
        if ($check_digit == 10) {
            $check_digit = 1;
        } elseif ($check_digit == 11) {
            $check_digit = 0;
        }

        return $check_digit . $number;
    }

    /**
     * Set the transaction ID.
     *
     * @param int|string $transaction_id
     *   Integer or numeric string with a transaction identifier like an
     *   invoice number or order number.  If the ID consists of more than
     *   15 digits, it is truncated and only the last 15 digits are used.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setTransactionID($transaction_id)
    {
        if (is_int($transaction_id)) {
            $transaction_id = (string)$transaction_id;
        } elseif (!is_string($transaction_id) || !ctype_digit($transaction_id)) {
            throw new \InvalidArgumentException();
        }

        // String length must be between 7 and 15 digits.
        if (strlen($transaction_id) < 7) {
            $transaction_id = str_pad($transaction_id, 7, '0', \STR_PAD_LEFT);
        } elseif (strlen($transaction_id) > 15) {
            $transaction_id = substr($transaction_id, -15);
        }

        $this->TransactionID = $transaction_id;
    }
}
