<?php
namespace StoreCore\Database;

/**
 * CRUD Interface
 *
 * Interface to Create, Read, Update, and Delete (CRUD) data objects.
 * An abstraction of this CRUD interface is provided by the abstract
 * class `StoreCore\Database\AbstractDataAccessObject`.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://en.wikipedia.org/wiki/Create,_read,_update_and_delete
 * @version   1.0.0
 */
interface CRUDInterface
{
    public function create(array $keyed_data);

    public function read($value, $key = null);

    public function update(array $keyed_data, $where_clause = null);

    public function delete($value, $key = null);
}
