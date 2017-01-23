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
     * @var string|null $EmailAddress
     * @var string|null $HashAlgorithm
     * @var string|null $PasswordHash
     * @var string|null $PasswordSalt
     * @var int|null    $PersonID
     * @var string      $PinCode
     * @var int         $UserGroupID
     * @var int|null    $UserID
     * @var string|null $Username
     */
    private $EmailAddress;
    private $HashAlgorithm;
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
     * @return string|null
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
     * @return void
     * @throws \UnexpectedValueException
     */
    public function setPIN($pin_code)
    {
        if (!is_numeric($pin_code)) {
            throw new \UnexpectedValueException(__METHOD__ . ' expects parameter 1 to be an integer or numeric string.');
        } elseif (strlen($pin_code) < 4 || strlen($pin_code) > 6) {
            throw new \UnexpectedValueException(__METHOD__ . ' expects parameter 1 to be a number consisting of 4 up to 6 digits.');
        }
        $this->PinCode = $pin_code;
    }

    /**
     * Set the user group identifier.
     *
     * @param int $user_group_id
     * @return void
     */
    public function setUserGroupID($user_group_id)
    {
        $this->UserGroupID = (int)$user_group_id;
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
