<?php
namespace StoreCore;

/**
 * StoreCore Store Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017-2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Store extends AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer)
     */
    const VERSION = '0.1.0';

    /**
     * @var \DateTimeZone $DateTimeZone
     *   Default date and time zone of the store.
     */
    private $DateTimeZone;

    /**
     * @var bool $EnabledFlag
     *   Determines whether the store is “open” to the public (true) or not
     *   (default false).
     */
    private $EnabledFlag = false;

    /**
     * @var bool $Secure
     *   Determines if the store is accessible over HTTPS (true) or plain HTTP
     *   without SSL (default false).
     */
    private $Secure = false;

    /**
     * @var array $StoreCurrencies
     *   Array with \StoreCore\Currency objects for the store’s currencies.
     */
    private $StoreCurrencies;

    /**
     * @var \StoreCore\Types\StoreID|null $StoreID
     *   Unique store identifier.
     */
    private $StoreID;

    /**
     * @var array $StoreLanguages
     *   Languages used for this store’s storefront.
     */
    private $StoreLanguages = array(
        'en-GB' => true,
    );

    /**
     * @var string $StoreName
     *   Generic short name of the store.
     */
    private $StoreName = '';

    /**
     * Construct a store model object.
     *
     * @param \StoreCore\Registry $registry
     *   Global StoreCore service locator.
     *
     * @return self
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);
        $this->DateTimeZone = new \DateTimeZone('UTC');
    }

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
     * Get the store's date and time zone.
     *
     * @param void
     *
     * @return \DateTimeZone
     *   Returns the current timezone for a store as a PHP DateTimeZone object.
     */
    public function getDateTimeZone()
    {
        return $this->DateTimeZone;
    }

    /**
     * Get the store’s currencies.
     *
     * @param void
     *
     * @return array
     *   Returns an indexed array with the store’s currencies with ISO currency
     *   numbers as the keys and \StoreCore\Currency objects as the values.
     */
    public function getStoreCurrencies()
    {
        return $this->StoreCurrencies;
    }

    /**
     * Get the store’s storefront languages.
     *
     * @param void
     *
     * @return array
     *   Returns an associative array with language IDs as the keys and a
     *   boolean as the values.  The boolean value is set to true if the
     *   language is currently enabled for the storefront.  The first array
     *   element is the store’s default language.
     */
    public function getStoreLanguages()
    {
        return $this->StoreLanguages;
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
     *
     * @return \StoreCore\Types\StoreID|null
     *   Returns the store ID as a data object or null if the store does not
     *   have an ID yet.
     */
    public function getStoreID()
    {
        return $this->StoreID;
    }

    /**
     * Get the store's timezone identifier.
     *
     * @param void
     *
     * @return string
     *   Returns one of the default PHP timezone identifiers as a string.
     */
    public function getTimezoneID()
    {
        return $this->DateTimeZone->getName();
    }

    /**
     * Check if the store runs over HTTPS (HTTP Secure).
     *
     * @param void
     *
     * @return bool
     *   Returns true if the store uses secure HTTPS connections, otherwise
     *   false.
     */
    public function isSecure()
    {
        return $this->Secure;
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
     * Enforce HTTP Secure (HTTPS).
     *
     * @param void
     * @return void
     */
    public function secure()
    {
        $this->Secure = true;
    }

    /**
     * Set the store’s currencies.
     *
     * @param array $store_currencies
     * @return void
     */
    public function setStoreCurrencies(array $store_currencies)
    {
        $this->StoreCurrencies = $store_currencies;
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
     * Set the store’s storefront languages.
     *
     * @param array $store_languages
     * @return void
     */
    public function setStoreLanguages(array $store_languages)
    {
        $this->StoreLanguages = $store_languages;
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

    /**
     * Set the store's date and time zone.
     *
     * @param \DateTimeZone|string $timezone
     *   The timezone to set as a DateTimeZone PHP object or one of the PHP
     *   timezone identifier.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the parameter is not a
     *   DateTimeZone instance, not a string, an empty string, or an unknown
     *   PHP timezone identifier.
     *
     * @uses \DateTimeZone::listIdentifiers()
     */
    public function setDateTimeZone($timezone)
    {
        if ($timezone instanceof \DateTimeZone) {
            $this->DateTimeZone = $timezone;
        } elseif (is_string($timezone) && !empty($timezone)) {
            $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            if (in_array($timezone, $timezones)) {
                $this->DateTimeZone = new \DateTimeZone($timezone);
            } else {
                throw new \InvalidArgumentException();
            }
        } else {
            throw new \InvalidArgumentException();
        }
    }
}
