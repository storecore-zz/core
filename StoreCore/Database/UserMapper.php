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
     */
    public function getUserByEmailAddress($email_address)
    {
        $email_address = filter_var($email_address, FILTER_VALIDATE_EMAIL);
        if ($email_address === false) {
            return null;
        }

        $result = $this->fetch($email_address, 'email_address');
        if (count($result) == 1) {
            $user_data = $result[0];
            unset($result);
            $user = new \StoreCore\User();
            $user->setUserID($user_data['user_id']);
            $user->setUsername($user_data['username']);
            return $user;
        } else {
            return null;
        }
    }
}  
