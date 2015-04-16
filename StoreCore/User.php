<?php
namespace StoreCore;

/**
 * StoreCore User
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.0.1
 */
class User
{
    /** @var string VERSION */
    const VERSION = '0.0.1';

    /**
     * @var string   $EmailAddress
     * @var string   $HashAlgorithm
     * @var string   $PasswordHash
     * @var string   $PasswordSalt
     * @var int|null $UserGroupID
     * @var int      $UserID
     * @var string   $Username
     */
    private $EmailAddress;
    private $HashAlgorithm;
    private $PasswordHash;
    private $PasswordSalt;
    private $UserGroupID;
    private $UserID;
    private $Username;

    /**
     * Check the user credentials.
     *
     * @api
     *
     * @param string $password
     *
     * @return bool
     *     Returns true if the user credentials check out and the user may be
     *     granted access to parts of the StoreCore framework, otherwise false.
     *     Members of user group 0 (zero) are always denied access.
     */
    public function authenticate($password)
    {
        if (!is_string($password)) {
            return false;
        }

        if ($this->getUserGroupID() === null || $this->getUserGroupID() < 1) {
            return false;
        }

        if ($this->HashAlgorithm === null || $this->PasswordHash === null || $this->PasswordSalt === null) {
            return false;
        }

        if ($this->HashAlgorithm == 'sha1') {
            $hash = sha1($this->PasswordSalt . $password);
        } else {
            $hash = hash($this->HashAlgorithm, $this->PasswordSalt . $password);
        }

        if ($hash == $this->PasswordHash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the user group identifier.
     *
     * @api
     * @param void
     * @return int|null
     */
    public function getUserGroupID()
    {
        return $this->UserGroupID;
    }

    /**
     * Get the user identifier.
     *
     * @api
     * @param void
     * @return int|null
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * @param string $email_address
     * @return $this
     */
    public function setEmailAddress($email_address)
    {
        $this->EmailAddress = $email_address;
        return $this;
    }

    /**
     * @param string $hash_algorithm
     * @return $this
     */
    public function setHashAlgorithm($hash_algorithm)
    {
        $this->HashAlgorithm = $hash_algorithm;
        return $this;
    }

    /**
     * @param string $password_hash
     * @return $this
     */
    public function setPasswordHash($password_hash)
    {
        $this->PasswordHash = $password_hash;
        return $this;
    }

    /**
     * @param string $password_salt
     * @return $this
     */
    public function setPasswordSalt($password_salt)
    {
        $this->PasswordSalt = $password_salt;
        return $this;
    }

    /**
     * @param int $user_group_id
     * @return $this
     */
    public function setUserGroupID($user_group_id)
    {
        $this->UserGroupID = (int)$user_group_id;
        return $this;
    }

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserID($user_id)
    {
        $this->UserID = (int)$user_id;
        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->Username = $username;
        return $this;
    }
}
