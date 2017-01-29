<?php
namespace StoreCore\Database;

/**
 * Access Control Whitelist Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class AccessControlWhitelist extends AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * @var int|null $Count
     *   Count of the total number of active IP addresses on the whitelist.
     *   If this count equals 0, the whitelist cannot be used because it is
     *   either empty or contains stale data.
     */
    private $Count;

    /**
     * Check if an active administrator IP address exists.
     *
     * @param string $remote_address
     * @return bool
     */
    public function administratorExists($remote_address)
    {
        return $this->exists($remote_address, true);
    }

    /**
     * Check if an active API client IP address exists.
     *
     * @param string $remote_address
     * @return bool
     */
    public function clientExists($remote_address)
    {
        return $this->exists($remote_address, false);
    }

    /**
     * Count the total number of active IP addresses.
     *
     * @param void
     * @return int
     */
    public function count()
    {
        /*
            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE from_date < UTC_TIMESTAMP()
               AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())
         */
        $sql = 'SELECT COUNT(*) FROM sc_ip_whitelist WHERE from_date < UTC_TIMESTAMP() AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())';
        $stmt = $this->Connection->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        $stmt = null;
        $this->Count = (int)$row[0];
        return $this->Count;
    }

    /**
     * Count the number of whitelisted administrator IP addresses.
     *
     * @param void
     * @return int
     */
    public function countAdministrators()
    {
        /*
            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE admin_flag = 1
               AND from_date < UTC_TIMESTAMP()
               AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())
         */
        $sql = 'SELECT COUNT(*) FROM sc_ip_whitelist WHERE admin_flag = 1 AND from_date < UTC_TIMESTAMP() AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())';
        $stmt = $this->Connection->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        $stmt = null;
        return (int)$row[0];
    }

    /**
     * Count the number of whitelisted API client IP addresses.
     *
     * @param void
     * @return int
     */
    public function countClients()
    {
        /*
            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE api_flag = 1
               AND from_date < UTC_TIMESTAMP()
               AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())
         */
        $sql = 'SELECT COUNT(*) FROM sc_ip_whitelist WHERE api_flag = 1 AND from_date < UTC_TIMESTAMP() AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())';
        $stmt = $this->Connection->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        $stmt = null;
        return (int)$row[0];
    }

    /**
     * Check if an active IP address exists.
     *
     * @internal
     * @param string $remote_address
     * @param bool $admin_flag
     * @return bool
     */
    private function exists($remote_address, $admin_flag = true)
    {
        if ($this->Count === 0) {
            return false;
        }

        $remote_address = filter_var($remote_address, FILTER_VALIDATE_IP);
        if ($remote_address === false) {
            return false;
        }

        /*
            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE admin_flag = 1
               AND from_date < UTC_TIMESTAMP()
               AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())
               AND ip_address = :remote_address

            SELECT COUNT(*)
              FROM sc_ip_whitelist
             WHERE api_flag = 1
               AND from_date < UTC_TIMESTAMP()
               AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())
               AND ip_address = :remote_address
         */
        $sql = 'SELECT COUNT(*) FROM sc_ip_whitelist WHERE ';
        if ($admin_flag) {
            $sql .= 'admin_flag = 1 AND ';
        } else {
            $sql .= 'api_flag = 1 AND ';
        }
        $sql .= 'from_date < UTC_TIMESTAMP() AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP()) AND ip_address = :remote_address';

        $stmt = $this->Connection->prepare($sql);
        $stmt->bindParam(':remote_address', $remote_address, \PDO::PARAM_STR);
        if ($stmt->execute()) {
            $number_of_rows = $stmt->fetchColumn();
            $stmt->closeCursor();
            $stmt = null;
            if ($number_of_rows == 1) {
                return true;
            }
        }
        return false;
    }
}
