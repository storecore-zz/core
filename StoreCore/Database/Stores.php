<?php
namespace StoreCore\Database;

/**
 * Stores Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Stores extends \StoreCore\Database\AbstractModel implements \Countable
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Count the number of active stores.
     *
     * @param void
     *
     * @return int
     *   Returns the total number of active or “open” stores as an integer.
     */
    public function count()
    {
        $stmt = $this->Connection->query('SELECT COUNT(store_id) FROM sc_stores WHERE enabled_flag = 1');
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        return (int)$row[0];
    }
}
