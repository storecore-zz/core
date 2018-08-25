<?php
namespace StoreCore\Types;

/**
 * Schema.org Geographic Coordinates
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/GeoCoordinates
 * @version   0.1.0
 */
class GeoCoordinates extends StructuredValue
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Construct schema.org GeoCoordinates
     *
     * @param float|string|null $latitude
     *   Optional latitude of the geographic coordinates.
     *
     * @param float|string|null $longitude
     *   Optional longitude of the geographic coordinates.
     *
     * @return self
     */
    public function __construct($latitude = null, $longitude = null)
    {
        $this->setType('GeoCoordinates');
        if ($latitude !== null) {
            $this->setLatitude($latitude);
            if ($longitude !== null) {
                $this->setLongitude($longitude);
            }
        }
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
        $this->Data['addressCountry'] = $address_country;
    }

    /**
     * Set the elevation.
     *
     * @param float|string $elevation
     *
     * @return void
     */
    public function setElevation($elevation)
    {
        $this->Data['elevation'] = $elevation;
    }

    /**
     * Set the latitude.
     *
     * @param float|string $latitude
     *
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->Data['latitude'] = $latitude;
    }

    /**
     * Set the longitude.
     *
     * @param float|string $longitude
     *
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->Data['longitude'] = $longitude;
    }

    /**
     * Set the location postal code.
     *
     * @param string $postal_code
     *
     * @return void
     *
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
