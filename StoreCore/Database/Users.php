<?php
namespace StoreCore\Database;

/**
 * Users
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Users extends \StoreCore\Database\AbstractModel implements \Countable
{
    /** @var string VERSION Semantic Version (SemVer) */
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
        $stmt = $this->Database->query(
            'SELECT COUNT(user_id) FROM sc_users WHERE user_group_id != 0'
        );
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        return (int)$row[0];
    }
}
