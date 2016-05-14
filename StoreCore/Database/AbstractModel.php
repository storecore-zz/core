<?php
namespace StoreCore\Database;

/**
 * Abstract MVC Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @uses \StoreCore\AbstractModel
 *   This abstract model class extends the core abstract model by adding a
 *   database connection.  Its main purpose therefore is to build MVC models
 *   that require access to a database.
 */
abstract class AbstractModel extends \StoreCore\AbstractModel
{
    const VERSION = '0.1.0';

    public function __construct(\StoreCore\Registry $registry)
    {
        $this->Registry = $registry;

        if (false === $this->Registry->has('Connection')) {
            $this->Registry->set('Connection', new \StoreCore\Database\Connection());
        }
    }
}
