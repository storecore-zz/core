<?php
namespace StoreCore\Types;

/**
 * Schema.org Postal Address
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/PostalAddress
 * @version   0.1.0
 */
class PostalAddress extends ContactPoint
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
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
     * @return void
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
    }

    /**
     * Set the address locality.
     *
     * @param string $address_locality
     * @return void
     */
    public function setAddressLocality($address_locality)
    {
        $this->setStringProperty('addressLocality', $address_locality);
    }

    /**
     * Set the address region.
     *
     * @param string $address_region
     * @return void
     */
    public function setAddressRegion($address_region)
    {
        $this->setStringProperty('addressRegion', $address_region);
    }

    /**
     * Set the address postcode.
     *
     * @param string $postal_code
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setPostalCode($postal_code)
    {
        if (!is_string($postal_code)) {
            throw new \InvalidArgumentException();
        }
        $postal_code = strtoupper($postal_code);
        $this->setStringProperty('postalCode', $postal_code);
    }
}
