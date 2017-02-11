<?php
namespace StoreCore\Types;

/**
 * Schema.org Geographic Coordinates
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/GeoCoordinates
 * @version   0.1.0
 */
class GeoCoordinates extends StructuredValue
{
    const VERSION = '0.1.0';

    /**
     * @param float|string|null $latitude
     * @param float|string|null $longitude
     * @return void
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
        $this->Data['addressCountry'] = $address_country;
        return $this;
    }

    /**
     * Set the elevation.
     *
     * @param float|string $elevation
     * @return $this
     */
    public function setElevation($elevation)
    {
        $this->Data['elevation'] = $elevation;
        return $this;
    }

    /**
     * Set the latitude.
     *
     * @param float|string $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->Data['latitude'] = $latitude;
        return $this;
    }

    /**
     * Set the longitude.
     *
     * @param float|string $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->Data['longitude'] = $longitude;
        return $this;
    }

    /**
     * Set the location postal code.
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
