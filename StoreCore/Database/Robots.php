<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractModel;

/**
 * Robots Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.0.2
 *
 * @see https://moz.com/learn/seo/robotstxt
 *      Robots.txt – Moz SEO Learning Center
 *
 * @see https://developers.google.com/search/reference/robots_txt?hl=en
 *      Robots.txt Specifications – Google Developers Search Reference
 */
class Robots extends AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.0.2';

    /**
     * Get all disallowed paths by user agent.
     *
     * @param void
     *
     * @return array
     *   Returns an associative array with a single entry per robot
     *   and possibly multiple `Disallow` locations for that robot.
     */
    public function getAllDisallows()
    {
        $disallows = array();

        /*
            SELECT
              d.disallow,
              r.user_agent
            FROM
              sc_robot_disallows d
            LEFT JOIN
              sc_robots r
            ON
              d.robot_id = r.robot_id
         */
        $stmt = $this->Database->prepare('SELECT d.disallow, r.user_agent FROM sc_robot_disallows d LEFT JOIN sc_robots r ON d.robot_id = r.robot_id');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $disallows[$row['user_agent']][] = $row['disallow'];
        }
        $stmt->closeCursor();

        return $disallows;
    }
}
