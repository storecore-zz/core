<?php
namespace StoreCore\Database;

/**
 * Robots Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   0.0.1
 */
class Robots extends \StoreCore\AbstractModel
{
    const VERSION = '0.0.1';

    /**
     * Get all disallowed paths by user agent.
     *
     * @param void
     * @return array
     */
    public function getAllDisallows()
    {
        $disallows = array();

        $sql = '
            SELECT
              d.disallow,
              r.user_agent
            FROM
              sc_robot_disallows d
            LEFT JOIN
              sc_robots r
            ON
              d.robot_id = r.robot_id';

        $dbh = new \StoreCore\Database\Connection();

        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $disallows[$row['user_agent']][] = $row['disallow'];
        }

        return $disallows;
    }
}
