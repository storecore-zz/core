<?php
namespace StoreCore\Database;

/**
 * Login Audit Maintenance & Management
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class LoginAuditManager extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Count the recently failed login attempts.
     *
     * @param int $minutes
     *   Size of the time frame in minutes, defaults to 60 minutes for the last
     *   hour.
     *
     * @return int
     *   Number of failed attempts to log in within the provided time frame.
     */
    public function countLastFailedAttempts($minutes = 60)
    {
        $minutes = (int)abs($minutes);
        $sql = 'SELECT COUNT(*) FROM sc_login_attempts WHERE successful = 0 AND attempted > DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $minutes . ' MINUTE)';
        $result = $this->Database->query($sql);
        $row = $result->fetch(\PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * Clean up the login attempts table.
     *
     * This method deletes all attempts to log in after 7 years and successful
     * attempts after 90 days.  Therefore unsuccessful, and possibly harmful,
     * failed attempts are stored for up to 7 years.
     *
     * @param void
     *
     * @return int
     *   Number of deleted rows.
     */
    public function optimize()
    {
        $affected_rows = $this->Database->exec('
            DELETE
              FROM sc_login_attempts
             WHERE attempted < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 7 YEAR)
        ');

        $affected_rows += $this->Database->exec('
            DELETE
              FROM sc_login_attempts
             WHERE successful = 1
               AND attempted < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 90 DAY)
        ');

        $this->Database->exec('OPTIMIZE TABLE sc_login_attempts');

        return $affected_rows;
    }
}
