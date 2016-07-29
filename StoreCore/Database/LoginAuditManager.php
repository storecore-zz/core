<?php
namespace StoreCore\Database;

/**
 * Login Audit Maintenance & Management
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class LoginAuditManager extends AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * Count the recently failed login attempts.
     *
     * @param int $minutes
     *   Size of the time frame in minutes, defaults to 60 minutes for the last
     *   hour.
     *
     * @return int
     */
    public function countLastFailedAttempts($minutes = 60)
    {
        $minutes = (int)abs($minutes);
        $sql = 'SELECT COUNT(*) FROM sc_login_attempts WHERE successful = 0 AND attempted > DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $minutes . ' MINUTE)';
        $result = $this->Connection->query($sql);
        $row = $result->fetch(\PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * Clean up the login attempts table.
     *
     * @param void
     *
     * @return int
     *   Number of deleted rows.
     */
    public function optimize()
    {
        // Delete all attempts after 7 years
        $sql = 'DELETE FROM sc_login_attempts WHERE attempted < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 7 YEAR)';
        $affected_rows = $this->Connection->exec($sql);

        // Delete successful attempts after 90 days
        $sql = 'DELETE FROM sc_login_attempts WHERE successful = 1 AND attempted < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 90 DAY)';
        $affected_rows += $this->Connection->exec($sql);

        // Optimize the database table
        $this->Connection->exec('OPTIMIZE TABLE sc_login_attempts');

        return $affected_rows;
    }
}
