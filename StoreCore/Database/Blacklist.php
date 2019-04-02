<?php
namespace StoreCore\Database;

/**
 * Blacklist Model
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Blacklist extends AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer)
     */
    const VERSION = '0.1.0';

    /**
     * Clear IP bans that are no longer in use.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function clear()
    {
        try {
            $this->Database->exec('DELETE FROM sc_ip_blacklist WHERE thru_date IS NOT NULL AND thru_date < UTC_TIMESTAMP()');
            return true;
        } catch (\PDOException $e) {
            $this->Logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Blacklist an IP address with an optional comment.
     *
     * @param string $ip_address
     *   IPv4 or IPv6 address to blacklist.  To allow for easy database, 
     *   blocklists, and server maintenance, IP addresses are handled and
     *   stored as text in dot-decimal notation (IPv4) or text with hexadecimal
     *   digits (IPv6).
     *
     * @param string|null $reason
     *   Optional short comment describing the reason for blacklisting the
     *   given IP address.
     *
     * @return bool
     *   Returns true on success and false on a failure.
     *
     * @throws \InvalidArgumentException
     *   An SPL invalid argument logic exception is throw if the first
     *   parameter `$ip_address` is not a valid IP address or if the optional
     *   second parameter `$reason` is not a string.
     *
     * @throws \LengthException
     *   Throws a length logic exception if the `$reason` string parameter has
     *   a string length of over 255 characters.
     */
    public function create($ip_address, $reason = null)
    {
        $ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);
        if ($ip_address === false) {
            throw new \InvalidArgumentException();
        }

        try {
            $stmt = $this->Database->prepare('INSERT INTO sc_ip_blacklist (ip_address, from_date) VALUES (:ip_address, UTC_TIMESTAMP())');
            $stmt->bindParam(':ip_address', $ip_address, \PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            $this->Logger->error($e->getMessage());
            return false;
        }

        if ($reason !== null) {
            if (!is_string($reason)) {
                throw new \InvalidArgumentException();
            }

            $reason = trim($reason);
            if (mb_strlen($password, 'UTF-8') > 255) {
                throw new \LengthException();
            }

            $stmt = $this->Database->prepare('INSERT INTO sc_ip_blacklist_comments (ip_address, comments) VALUES (:ip_address, :comments)');
            $stmt->bindParam(':ip_address', $ip_address, \PDO::PARAM_STR);
            $stmt->bindParam(':comments', $reason, \PDO::PARAM_STR);
            $stmt->execute();
        }

        return true;
    }

    /**
     * Remove a blacklisted IP address.
     *
     * This method removes an IP ban by setting the end date to the current
     * time in UTC.  The blacklisted IP address and optional notes are kept
     * for reference purposes, but MAY be deleted with the clear() method.
     *
     * @param string $ip_address
     *   IPv4 or IPv6 address to remove from the blacklist.
     *
     * @return bool
     *   Returns true on success or false on failure.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception on an invalid IP address.
     */
    public function delete($ip_address)
    {
        $ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);
        if ($ip_address === false) {
            throw new \InvalidArgumentException();
        }

        try {
            $stmt = $this->Database->prepare('UPDATE sc_ip_blacklist SET thru_date = UTC_TIMESTAMP() WHERE ip_address = :ip_address');
            $stmt->bindParam(':ip_address', $ip_address, \PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            $this->Logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Read the active IP bans.
     *
     * @param void
     *
     * @return array|null
     *   Returns an associative array with the blacklisted IP address as the
     *   key and the date and time it was blacklisted as the value.  Null is
     *   returned if there currently are no active IP bans.
     */
    public function read()
    {
        /*
              SELECT ip_address, from_date
                FROM sc_ip_blacklist
               WHERE thru_date IS NULL
                  OR thru_date > UTC_TIMESTAMP()
            ORDER BY from_date DESC
         */
        $stmt = $this->Database->prepare('SELECT ip_address, from_date FROM sc_ip_blacklist WHERE thru_date IS NULL OR thru_date > UTC_TIMESTAMP() ORDER BY from_date DESC');
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_NUM);
        $stmt = null;

        if (empty($result) || !is_array($result)) {
            return null;
        }

        $return = array();
        foreach ($result as $value) {
            $return[$value[0]] = $value[1];
        }
        return $return;
    }
}
