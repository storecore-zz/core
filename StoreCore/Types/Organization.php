<?php
namespace StoreCore\Types;

/**
 * Schema.org Organization
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Organization
 * @version   0.1.0
 */
class Organization extends Thing
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'airline' => 'Airline',
        'corporation' => 'Corporation',
        'educationalorganization' => 'EducationalOrganization',
        'governmentorganization' => 'GovernmentOrganization',
        'localbusiness' => 'LocalBusiness',
        'medicalorganization' => 'MedicalOrganization',
        'ngo' => 'NGO',
        'organisation' => 'Organization',
        'organization' => 'Organization',
        'performinggroup' => 'PerformingGroup',
        'sportsorganization' => 'SportsOrganization',
        'workersunion' => 'WorkersUnion',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Organization');
    }

    /**
     * Get the item name.
     *
     * @param void
     * @return string|null
     */
    public function getName()
    {
        if (array_key_exists('name', $this->Data)) {
            return $this->Data['name'];
        } elseif (array_key_exists('alternateName', $this->Data)) {
            return $this->Data['alternateName'];
        } elseif (array_key_exists('legalName', $this->Data)) {
            return $this->Data['legalName'];
        } else {
            return null;
        }
    }

    /**
     * Set the postal address of an organization.
     *
     * This method sets the postal address of the organization, which MAY be a
     * a physical address.  Use the `setLocation()` method if you need to include
     * the geographical coordinates of the location.
     *
     * @param PostalAddress $address
     *
     * @return void
     */
    public function setAddress(PostalAddress $address)
    {
        $this->Data['address'] = $address;
    }

    /**
     * Set the overall rating of the organization.
     *
     * @param AggregateRating $aggregate_rating
     *   The overall rating, based on a collection of reviews or ratings, of
     *   the organization.
     *
     * @return void
     */
    public function setAggregateRating(AggregateRating $aggregate_rating)
    {
        $this->Data['aggregateRating'] = $aggregate_rating;
    }

    /**
     * Set the organization's official name.
     *
     * @param string
     *   The official name of the organization, for example the registered
     *   company name.
     *
     * @return void
     */
    public function setLegalName($legal_name)
    {
        $this->setStringProperty('legalName', $legal_name);
    }

    /**
     * Set the location of an organization.
     *
     * @param Place|PostalAddress|string $location
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setLocation($location)
    {
        if (is_string($location)) {
            $this->setStringProperty('location', $location);
        } elseif ($location instanceof PostalAddress) {
            $this->setAddress($location);
        } elseif ($location instanceof Place) {
            $this->Data['location'] = (string)$location;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * Set the organization logo.
     *
     * @param ImageObject|string
     *   The fully-qualified URL of the logo image file or an ImageObject.
     *
     * @see https://developers.google.com/search/docs/data-types/logo
     *
     * @return void
     */
    public function setLogo($logo)
    {
        $this->Data['logo'] = $logo;
    }

    /**
     * Set the telephone number.
     *
     * @param string $telephone
     * @return void
     */
    public function setTelephone($telephone)
    {
        $this->setStringProperty('telephone', $telephone);
    }
}
