<?php
namespace StoreCore\Database;

/**
 * User Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class UserMapper extends AbstractDataAccessObject
{
    /**
     * @var string PRIMARY_KEY DAO database table primary key.
     * @var string TABLE_NAME  DAO database table name.
     * @var string VERSION     Semantic Version (SemVer).
     */
    const PRIMARY_KEY = 'user_id';
    const TABLE_NAME  = 'sc_users';
    const VERSION = '0.1.0';

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
     * @param array $user_data
     * @return \StoreCore\User
     */
    private function getUserObject(array $user_data)
    {
        $user = new \StoreCore\User();

        $user->setUserID($user_data['user_id']);
        $user->setUserGroupID($user_data['user_group_id']);
        $user->setLanguage($user_data['language_id']);
        $user->setEmailAddress($user_data['email_address']);
        $user->setUsername($user_data['username']);
        $user->setPasswordSalt($user_data['password_salt']);
        $user->setHashAlgorithm($user_data['hash_algo']);
        $user->setPasswordHash($user_data['password_hash']);
        $user->setPIN($user_data['pin_code']);
        $user->setDateTimeZone($user_data['date_time_zone']);

        if ($user_data['person_id'] !== null) {
            $user->setPersonID($user_data['person_id']);
        }

        return $user;
    }

    /**
     * Fetch a user by the user's e-mail address.
     *
     * @param string $email_address
     * @return \StoreCore\User|null
     * @throws \InvalidArgumentException
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
            return $this->getUserObject($user_data);
        } else {
            return null;
        }
    }

    /**
     * Fetch a user by the user's username.
     *
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
            return $this->getUserObject($user_data);
        } else {
            return null;
        }
    }

    /**
     * Save a user.
     *
     * @param \StoreCore\User $user
     *
     * @return bool
     *   Returns true on success or false on failure.
     *
     * @throws \DomainException
     *   A domain logic exception is thrown if required user data are missing.
     */
    public function save(\StoreCore\User &$user)
    {
        if ($user->getUserID() === null) {
            $user_data = array(
                'password_reset' => gmdate('Y-m-d H:i:s'),
            );
        } else {
            $user_data = array(
                self::PRIMARY_KEY => $user->getUserID(),
                'user_group_id' => 0,
            );
        }

        $user_data['user_group_id'] = $user->getUserGroupID();
        $user_data['language_id'] = $user->getLanguage();
        $user_data['email_address'] = $user->getEmailAddress();
        $user_data['username'] = $user->getUsername();
        $user_data['password_salt'] = $user->getPasswordSalt();
        $user_data['hash_algo'] = $user->getHashAlgorithm();
        $user_data['password_hash'] = $user->getPasswordHash();
        $user_data['pin_code'] = $user->getPIN();
        $user_data['date_time_zone'] = $user->getDateTimeZone();

        if (in_array(null, $user_data, true)) {
            throw new \DomainException();
        }

        if ($user->getPersonID() !== null) {
            $user_data['person_id'] = $user->getPersonID();
        }

        if ($user->getUserID() === null) {
            $result = $this->create($user_data);
            if (is_numeric($result)) {
                $user->setUserID($result);
                return true;
            } else {
                return false;
            }
        } else {
            return $this->update($user_data);
        }
    }
}
