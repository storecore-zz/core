<?php
namespace StoreCore\Admin;

/**
 * PCI DSS Password Compliance
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class PasswordCompliance
{
    const VERSION = '0.1.0';

    /**
     * @var int MINIMUM_LENGTH
     *   Current minimum length of a password.
     */
    const MINIMUM_LENGTH = 7;

    /**
     * Validate the password compliance.
     *
     * @param string $password
     *
     * @return bool
     *   Returns true if the password matches the current compliance rule set,
     *   otherwise false.
     *
     * @todo
     *   Currently there are only two strict PCI DSS requirements.  Passwords
     *   and pass phrases (i) require a minimum length of at least seven
     *   characters and (ii) must contain both numeric and alphabetic
     *   characters.  Alternatively, the passwords/phrases MUST have
     *   complexity and strength at least equivalent to the parameters
     *   specified above, so the rule set MAY be extended.
     *
     * @see https://www.pcisecuritystandards.org/documents/PCI_DSS_v3.pdf
     *   Payment Card Industry (PCI) Data Security Standard
     *   Requirements and Security Assessment Procedures
     */
    public static function validate($password)
    {
        // Nothing to do.
        if (!is_string($password)) {
            return false;
        }

        // Not a number (NaN).
        if (is_numeric($password)) {
            return false;
        }

        // Set internal character encoding to UTF-8.
        mb_internal_encoding('UTF-8');

        // Require a minimum length of at least 7 characters.
        $string_length = mb_strlen($password);
        if ($string_length < self::MINIMUM_LENGTH) {
            return false;
        }

        // Require both numeric and alphabetic characters.
        $characters = str_ireplace(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), '', $password);
        if (mb_strlen($characters) == $string_length) {
            return false;
        }

        return true;
    }
}
