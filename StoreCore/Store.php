<?php
namespace StoreCore;

/**
 * Store Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Store extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var bool $EnabledFlag
     *   Determines whether the store is “open” to the public (true) or not
     *   (default false).
     */
    private $EnabledFlag = false;

    /**
     * @var \StoreCore\Types\StoreID $StoreID
     *   Unique store identifier.
     */
    private $StoreID;

    /**
     * @var string $StoreName
     *   Generic short name of the store.
     */
    private $StoreName = '';

    /**
     * Close the store.
     *
     * @param void
     * @return void
     */
    public function close()
    {
        $this->EnabledFlag = false;
    }

    /**
     * Get the store name.
     *
     * @param void
     * @return string
     */
    public function getStoreName()
    {
        return $this->StoreName;
    }

    /**
     * Get the store identifier.
     *
     * @param void
     * @return \StoreCore\Types\StoreID
     */
    public function getStoreID()
    {
        return $this->StoreID;
    }

    /**
     * Check if a store is open or closed.
     *
     * @param void
     *
     * @return bool
     *   Returns true if the store currently is open and false if it is closed.
     *   A store is closed (false) by default, unless it was explicitly opened
     *   with the `open()` method.
     */
    public function isOpen()
    {
        return $this->EnabledFlag;
    }

    /**
     * Open the store.
     *
     * @param void
     * @return void
     */
    public function open()
    {
        $this->EnabledFlag = true;
    }

    /**
     * Set the store identifier.
     *
     * @param \StoreCore\Types\StoreID|int $store_id
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setStoreID($store_id)
    {
        if (is_int($store_id)) {
            $store_id = new \StoreCore\Types\StoreID($store_id);
        }

        if ($store_id instanceof \StoreCore\Types\StoreID) {
            $this->StoreID = $store_id;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * Set the store name.
     *
     * @param string $store_name
     *   Generic short name of the store.  Because this store name is displayed
     *   in the backoffice, it is RECOMMENDED to use a unique, distinguishable
     *   name for each store.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the parameter is not a
     *   string or an empty string.
     */
    public function setStoreName($store_name)
    {
        if (!is_string($store_name)) {
            throw new \InvalidArgumentException();
        }

        $store_name = trim($store_name);
        if (empty($store_name)) {
            throw new \InvalidArgumentException();
        }

        $this->StoreName = $store_name;
    }
}
