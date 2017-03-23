<?php
namespace StoreCore;

/**
 * StoreCore User
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class User
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string      $DateTimeZone
     * @var string|null $EmailAddress
     * @var string|null $HashAlgorithm
     * @var string      $LanguageID
     * @var string|null $PasswordHash
     * @var string|null $PasswordSalt
     * @var int|null    $PersonID
     * @var string      $PinCode
     * @var int         $UserGroupID
     * @var int|null    $UserID
     * @var string|null $Username
     */
    private $DateTimeZone = 'UTC';
    private $EmailAddress;
    private $HashAlgorithm;
    private $LanguageID = 'en-GB';
    private $PasswordHash;
    private $PasswordSalt;
    private $PersonID;
    private $PinCode = '0000';
    private $UserGroupID = 0;
    private $UserID;
    private $Username;

    /**
     * Check the user credentials.
     *
     * @param string $password
     *
     * @return bool
     *   Returns true if the user credentials check out and the user may be
     *   granted access to parts of the StoreCore framework, otherwise false.
     *   Members of user group 0 (zero) are always denied access.
     */
    public function authenticate($password)
    {
        if (!is_string($password) || empty($password)) {
            return false;
        }

        if ($this->getUserGroupID() === null || $this->getUserGroupID() < 1) {
            return false;
        }

        if ($this->PasswordHash === null || $this->PasswordSalt === null) {
            return false;
        }

        if ($this->HashAlgorithm == 'SHA-1') {
            $hash = sha1($this->PasswordSalt . $password);
        } else {
            $hash_factory = new \StoreCore\Database\Password();
            $hash_factory->setPassword($password);
            $hash_factory->setSalt($this->PasswordSalt);
            $hash_factory->encrypt();
            $hash = $hash_factory->getHash();
        }

        if ($hash == $this->PasswordHash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the user’s timezone.
     *
     * @param void
     *
     * @return string
     *   Returns a DateTimeZone identifier as a string.  The default for all
     *   StoreCore dates, times, and datetimes is 'UTC'.
     */
    public function getDateTimeZone()
    {
        return $this->DateTimeZone;
    }

    /**
     * Get the e-mail address.
     *
     * @param void
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }

    /**
     * Get the password hash algorithm.
     *
     * @param void
     * @return string|null
     */
    public function getHashAlgorithm()
    {
        return $this->HashAlgorithm;
    }

    /**
     * Get the user’s language identifier.
     *
     * @param void
     *
     * @return string
     *   Returns a string like 'en-GB' (default) for the language ID.
     */
    public function getLanguageID()
    {
        return $this->LanguageID;
    }

    /**
     * Get the password hash.
     *
     * @param void
     * @return string|null
     */
    public function getPasswordHash()
    {
        return $this->PasswordHash;
    }

    /**
     * Get the password salt.
     *
     * @param void
     * @return string|null
     */
    public function getPasswordSalt()
    {
        return $this->PasswordSalt;
    }

    /**
     * Get the person identifier of this user.
     *
     * @param void
     * @return int|null
     */
    public function getPersonID()
    {
        return $this->PersonID;
    }

    /**
     * Get the personal identification number (PIN).
     *
     * @param void
     *
     * @return string
     *   Returns a numeric string with 4, 5 or 6 digits.  Defaults to '0000' if
     *   no other PIN code was set.
     */
    public function getPIN()
    {
        return $this->PinCode;
    }

    /**
     * Get the user group identifier.
     *
     * @param void
     * @return int
     */
    public function getUserGroupID()
    {
        return $this->UserGroupID;
    }

    /**
     * Get the user identifier.
     *
     * @param void
     * @return int|null
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * Get the username.
     *
     * @param void
     * @return string|null
     */
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * Set the user’s timezone.
     *
     * @param string $timezone_identifier
     *   DateTimeZone identifier for the user’s current date and time zone.
     *
     * @return string
     *   Returns the currently set timezone identifier.
     */
    public function setDateTimeZone($timezone_identifier)
    {
        $timezone_identifiers = \DateTimeZone::listIdentifiers();
        if (in_array($timezone_identifier, $timezone_identifiers, true)) {
            $this->DateTimeZone = $timezone_identifier;
        }
        return $this->getDateTimeZone();
    }

    /**
     * Set the e-mail address.
     *
     * @param string $email_address
     * @return void
     */
    public function setEmailAddress($email_address)
    {
        $this->EmailAddress = (string)$email_address;
    }

    /**
     * Set the password hash algorithm.
     *
     * @param string $hash_algorithm
     * @return void
     */
    public function setHashAlgorithm($hash_algorithm)
    {
        $this->HashAlgorithm = $hash_algorithm;
    }

    /**
     * Set the user’s language identifier.
     *
     * @param string $language_id
     *   Alphanumeric language identifier like 'en-GB' for British English
     *   or 'en-US' for American English.  If the current timezone is set
     *   to the generic 'UTC' (default) and a single timezone exists for the
     *   country code, the country code is also used to set the timezone.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the `$language_id`
     *   parameter is not a string consisting of 5 characters with the `aa-AA`
     *   format of an alphanumeric StoreCore language code.  This method
     *   does not validate if the language ID actually exists nor if the
     *   language is currently in use.
     */
    public function setLanguageID($language_id)
    {
        if (!is_string($language_id) || strlen($language_id) !== 5) {
            throw new \InvalidArgumentException();
        }

        $language_id = str_ireplace('_', '-', $language_id);
        $language_id = explode('-', $language_id);
        if (count($language_id) !== 2) {
            throw new \InvalidArgumentException();
        }

        $language_id[0] = strtolower($language_id[0]);
        $language_id[1] = strtoupper($language_id[1]);
        if (!ctype_lower($language_id[0]) || !ctype_upper($language_id[1])) {
            throw new \InvalidArgumentException();
        }

        if ($this->DateTimeZone === 'UTC') {
            $timezone_identifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $language_id[1]);
            if (count($timezone_identifiers) === 1) {
                $this->setDateTimeZone($timezone_identifiers[0]);
            }
        }

        $this->LanguageID = implode('-', $language_id);
    }

    /**
     * Set the password hash.
     *
     * @param string $password_hash
     * @return void
     */
    public function setPasswordHash($password_hash)
    {
        $this->PasswordHash = $password_hash;
    }

    /**
     * @param string $password_salt
     * @return void
     */
    public function setPasswordSalt($password_salt)
    {
        $this->PasswordSalt = $password_salt;
    }

    /**
     * Set the ID of the person associated with this user.
     *
     * @param int $person_id
     * @return void
     */
    public function setPersonID($person_id)
    {
        $this->PersonID = $person_id;
    }

    /**
     * Set the personal identification number (PIN).
     *
     * @param string $pin_code
     *
     * @return void
     *
     * @throws \UnexpectedValueException
     *   Throws an unexpected value runtime exception if the `$pin_code`
     *   parameter is not a number consisting of 4, 5 or 6 digits.
     */
    public function setPIN($pin_code)
    {
        if (!ctype_digit($pin_code) || strlen($pin_code) < 4 || strlen($pin_code) > 6) {
            throw new \UnexpectedValueException();
        }
        $this->PinCode = $pin_code;
    }

    /**
     * Set the user group identifier.
     *
     * @param int $user_group_id
     *   Unique user group identifier.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the `$user_group_id`
     *   parameter is not an integer.
     *
     * @throws \DomainException
     *   Throws a domain logic exception if the `$user_group_id` integer value
     *   is less than 0 or greater than 255, the default unsigned range of a
     *   `TINYINT` in MySQL.
     */
    public function setUserGroupID($user_group_id)
    {
        if (!is_int($user_group_id)) {
            throw new \InvalidArgumentException();
        }

        if ($user_group_id < 0 || $user_group_id > 255) {
            throw new \DomainException();
        }

        $this->UserGroupID = $user_group_id;
    }

    /**
     * Set the unique user identifier.
     *
     * @param int $user_id
     * @return void
     */
    public function setUserID($user_id)
    {
        $this->UserID = (int)$user_id;
    }

    /**
     * Set the username.
     *
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->Username = $username;
    }
}
