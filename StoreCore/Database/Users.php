<?php
namespace StoreCore\Database;

/**
 * User Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Users extends \StoreCore\Database\AbstractModel implements \Countable
{
    const VERSION = '0.1.0';


    /**
     * Count the number of active users.
     *
     * @param void
     *
     * @return int
     *   User accounts may be disabled, permanently or temporarily, by setting
     *   the user group ID to 0 (zero).  This method therefore returns a count
     *   of all users from different user groups (WHERE user_group_id != 0).
     */
    public function count()
    {
        $sql = 'SELECT SQL_NO_CACHE COUNT(*) FROM sc_users WHERE user_group_id != 0';
        $stmt = $this->Connection->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        return (int)$row[0];
    }
}
