<?php
namespace StoreCore;

/**
 * StoreCore User
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0-alpha.1
 */
class User
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * @var string $EmailAddress
     * @var string $HashAlgorithm
     * @var string $PasswordHash
     * @var string $PasswordSalt
     * @var string $PinCode
     * @var int    $UserGroupID
     * @var int    $UserID
     * @var string $Username
     */
    private $EmailAddress;
    private $HashAlgorithm;
    private $PasswordHash;
    private $PasswordSalt;
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
        if (!is_string($password)) {
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
     * Get the user group identifier.
     *
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
     * @param void
     * @return int|null
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * @param string $email_address
     * @return void
     */
    public function setEmailAddress($email_address)
    {
        $this->EmailAddress = $email_address;
    }

    /**
     * @param string $hash_algorithm
     * @return void
     */
    public function setHashAlgorithm($hash_algorithm)
    {
        $this->HashAlgorithm = $hash_algorithm;
    }

    /**
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
     * @param string $pin_code
     * @return void
     */    
    public function setPinCode($pin_code)
    {
        $this->PinCode = $pin_code;
    }
    
    /**
     * @param int $user_group_id
     * @return void
     */
    public function setUserGroupID($user_group_id)
    {
        $this->UserGroupID = (int)$user_group_id;
    }

    /**
     * @param int $user_id
     * @return void
     */
    public function setUserID($user_id)
    {
        $this->UserID = (int)$user_id;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->Username = $username;
    }
}
