<?php
namespace StoreCore\Types;

/**
 * Schema.org Postal Address
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/PostalAddress
 * @version   0.1.0
 */
class PostalAddress extends ContactPoint
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('PostalAddress');
    }

    /**
     * Set the country.
     *
     * @param string $address_country
     *   Two-letter ISO 3166-1 alpha-2 country code.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setAddressCountry($address_country)
    {
        if (!is_string($address_country)) {
            throw new \InvalidArgumentException();
        }

        $address_country = trim($address_country);
        if (strlen($address_country) !== 2) {
            throw new \InvalidArgumentException();
        }

        $address_country = strtoupper($address_country);
        $this->setStringProperty('addressCountry', $address_country);
        return $this;
    }

    /**
     * Set the address locality.
     *
     * @param string $address_locality
     * @return $this
     */
    public function setAddressLocality($address_locality)
    {
        $this->setStringProperty('addressLocality', $address_locality);
        return $this;
    }

    /**
     * Set the address region.
     *
     * @param string $address_region
     * @return $this
     */
    public function setAddressRegion($address_region)
    {
        $this->setStringProperty('addressRegion', $address_region);
        return $this;
    }

    /**
     * Set the address postcode.
     *
     * @param string $postal_code
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setPostalCode($postal_code)
    {
        if (!is_string($postal_code)) {
            throw new \InvalidArgumentException();
        }
        $postal_code = strtoupper($postal_code);
        $this->setStringProperty('postalCode', $postal_code);
        return $this;
    }
}
