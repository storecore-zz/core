<?php
namespace StoreCore\Database;

/**
 * IP Access Control Whitelist
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Whitelist extends \StoreCore\Database\AbstractModel implements \Countable
{
    const VERSION = '0.1.0';

    /**
     * Count the number of active addresses on the whitelist.
     *
     * @param void
     * @return int
     */
    public function count()
    {
        /*
            SELECT SQL_NO_CACHE COUNT(*)
              FROM sc_ip_whitelist
             WHERE (admin_flag = 1 OR api_flag = 1)
               AND from_date <= UTC_TIMESTAMP()
               AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())
         */
        $stmt = $this->Connection->prepare("SELECT SQL_NO_CACHE COUNT(*) FROM sc_ip_whitelist WHERE (admin_flag = 1 OR api_flag = 1) AND from_date <= UTC_TIMESTAMP() AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return (int)$count;
    }

    /**
     * Check if the whitelist table is empty.
     *
     * Note the differences between the Whitelist::count() method and the
     * Whitelist::isEmpty() method.  If isEmpty() returns true, there are no
     * whitelist records at all and the whitelist therefore SHOULD NOT be used
     * to grant or deny access to the administration.
     *
     * @param void
     * @return bool
     */
    public function isEmpty()
    {
        $stmt = $this->Connection->prepare('SELECT SQL_NO_CACHE COUNT(*) FROM sc_ip_whitelist');
        $stmt->execute();
        $count = (int) $stmt->fetchColumn();
        return ($count === 0) ? true : false;
    }

    /**
     * Check if an IP address is whitelisted.
     *
     * @param string $ip_address
     *   IPv4 or IPv6 address.
     *
     * @param bool $administration
     *   Optional flag to check whitelisted access to administration services.
     *   Defaults to false for lesser access control to API services.  This
     *   parameter MUST explicitly be set to a boolean true, and not a type
     *   that evaluates to true.
     *
     * @return bool
     */
    public function exists($ip_address, $administration = false)
    {
        $ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);
        if ($ip_address == false) {
            return false;
        }

        /*
         * If the (bool) $administration flag is true, the first query is
         * executed.  If not, the second query is executed.
         *
            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE ip_address = :ip_address
               AND admin_flag = 1
               AND from_date <= UTC_TIMESTAMP()
               AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())

            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE ip_address = :ip_address
               AND api_flag = 1
               AND from_date <= UTC_TIMESTAMP()
               AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())
         */
        $sql = 'SELECT COUNT(*) FROM sc_ip_whitelist WHERE ip_address = :ip_address ';
        if (true === $administration) {
            $sql .= 'AND admin_flag = 1';
        } else {
            $sql .= 'AND api_flag = 1';
        }
        $sql .= " AND from_date <= UTC_TIMESTAMP() AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())";

        try {
            $stmt = $this->Connection->prepare($sql);
            $stmt->bindParam(':ip_address', $ip_address);
            $stmt->execute();
            $count = (int) $stmt->fetchColumn(0);
        } catch (\PDOException $e) {
            return false;
        }

        return ($count === 1) ? true : false;
    }
}
