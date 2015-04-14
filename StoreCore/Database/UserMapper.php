<?php
namespace StoreCore\Database;

class UserMapper extends AbstractDataAccessObject
{
    const VERSION = '0.0.1';

    protected $TableName = 'sc_users';
    protected $PrimaryKey = 'user_id';

    /**
     * @param string $email_address
     * @return StoreCore\User|null
     * @throws InvalidArgumentException
     */
    public function getUserByEmailAddress($email_address)
    {
        $email_address = filter_var($email_address, FILTER_VALIDATE_EMAIL);
        if ($email_address === false) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects parameter 1 to be an e-mail address.');
        }

        $result = $this->fetch($email_address, 'email_address');
        if (count($result) == 1) {
            $user_data = $result[0];
            unset($result);
            $user = new \StoreCore\User();
            $user->setEmailAddress($user_data['email_address']);
            $user->setHashAlgorithm($user_data['hash_algo']);
            $user->setPasswordHash($user_data['password_hash']);
            $user->setPasswordSalt($user_data['password_salt']);
            $user->setUserGroupID($user_data['user_group_id']);
            $user->setUserID($user_data['user_id']);
            $user->setUsername($user_data['username']);
            return $user;
        } else {
            return null;
        }
    }

    /**
     * @param string $username
     * @return StoreCore\User|null
     */
    public function getUserByUsername($username)
    {
        // Check if the username matches an e-mail address
        $email_address = filter_var($username, FILTER_VALIDATE_EMAIL);
        if ($email_address !== false) {
            return $this->getUserByEmailAddress($email_address);
        }

        $result = $this->fetch($username, 'username');
        if (count($result) == 1) {
            $user_data = $result[0];
            unset($result);
            $user = new \StoreCore\User();
            $user->setEmailAddress($user_data['email_address']);
            $user->setHashAlgorithm($user_data['hash_algo']);
            $user->setPasswordHash($user_data['password_hash']);
            $user->setPasswordSalt($user_data['password_salt']);
            $user->setUserGroupID($user_data['user_group_id']);
            $user->setUserID($user_data['user_id']);
            $user->setUsername($user_data['username']);
            return $user;
        } else {
            return null;
        }
    }
}
