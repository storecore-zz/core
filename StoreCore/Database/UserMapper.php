<?php
namespace StoreCore\Database;

/**
 * User Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0-alpha.1
 */
class UserMapper extends AbstractDataAccessObject
{
    const VERSION = '0.1.0-alpha.1';

    const TABLE_NAME  = 'sc_users';
    const PRIMARY_KEY = 'user_id';

    /**
     * Ban a user.
     *
     * A user MAY be deleted from the database entirely.  For reference purposes
     * however, for example in historic data of user activity in order
     * processing and payment handling, it is RECOMMENDED to maintain the last
     * known user data.  Users that are no longer granted access, like former
     * employees, may therefore be "banned" by assigning them the special user
     * group ID 0 (zero).
     *
     * @api
     * @param \StoreCore\User $user
     * @return void
     * @uses \StoreCore\User::getUserID()
     */
    public function ban(\StoreCore\User $user)
    {
        $data = array(
            self::PRIMARY_KEY => $user->getUserID(),
            'user_group_id' => 0,
        );
        $this->update($data);
    }

    /**
     * Map the user's data to a user object.
     *
     * @internal
     * @param array $user_data
     * @return \StoreCore\User
     */
    private function getUser(array $user_data)
    {
        $user = new \StoreCore\User();
        $user->setEmailAddress($user_data['email_address']);
        $user->setHashAlgorithm($user_data['hash_algo']);
        $user->setPasswordHash($user_data['password_hash']);
        $user->setPasswordSalt($user_data['password_salt']);
        $user->setPinCode($user_data['pin_code']);
        $user->setUserGroupID($user_data['user_group_id']);
        $user->setUserID($user_data['user_id']);
        $user->setUsername($user_data['username']);
        return $user;
    }

    /**
     * Fetch a user by the user's e-mail address.
     *
     * @api
     * @param string $email_address
     * @return \StoreCore\User|null
     * @throws InvalidArgumentException
     */
    public function getUserByEmailAddress($email_address)
    {
        $email_address = filter_var($email_address, FILTER_VALIDATE_EMAIL);
        if ($email_address === false) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects parameter 1 to be an e-mail address.');
        }

        $result = $this->read($email_address, 'email_address');
        if (count($result) == 1) {
            $user_data = $result[0];
            unset($result);
            return $this->getUser($user_data);
        } else {
            return null;
        }
    }

    /**
     * Fetch a user by the user's username.
     *
     * @api
     * @param string $username
     * @return \StoreCore\User|null
     */
    public function getUserByUsername($username)
    {
        // Check if the username matches an e-mail address
        $email_address = filter_var($username, FILTER_VALIDATE_EMAIL);
        if ($email_address !== false) {
            return $this->getUserByEmailAddress($email_address);
        }

        $result = $this->read($username, 'username');
        if (count($result) == 1) {
            $user_data = $result[0];
            unset($result);
            return $this->getUser($user_data);
        } else {
            return null;
        }
    }
}
