<?php
namespace StoreCore\Database;

/**
 * Abstract MVC Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 *
 * @uses \StoreCore\AbstractModel
 *   This abstract model class extends the core abstract model by adding a
 *   database connection.  Its main purpose therefore is to build MVC models
 *   that require access to a database.
 */
abstract class AbstractModel extends \StoreCore\AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        if (false === $registry->has('Connection')) {
            $registry->set('Connection', new \StoreCore\Database\Connection());
        }
        $this->Registry = $registry;
    }
}
