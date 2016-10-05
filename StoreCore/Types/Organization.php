<?php
namespace StoreCore\Types;

/**
 * Schema.org Organization
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Organization
 * @version   0.1.0
 */
class Organization extends Thing
{
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
     * Set the postal address of an organization.
     *
     * This method sets the postal address of the organization, which MAY be a
     * a physical address.  Use the setLocation() method if you need to include
     * the geographical coordinates of the location.
     *
     * @param PostalAddress $address
     * @return $this
     */
    public function setAddress(PostalAddress $address)
    {
        $this->Data['address'] = $address;
        return $this;
    }

    /**
     * Set the overall rating of the organization.
     *
     * @param AggregateRating $aggregate_rating
     *   The overall rating, based on a collection of reviews or ratings, of
     *   the organization.
     *
     * @return $this
     */
    public function setAggregateRating(AggregateRating $aggregate_rating)
    {
        $this->Data['aggregateRating'] = $aggregate_rating;
        return $this;
    }

    /**
     * Set the location of an organization.
     *
     * @param Place|PostalAddress|string $location
     * @return $this
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
        return $this;
    }

    /**
     * Set the telephone number.
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->setStringProperty('telephone', $telephone);
        return $this;
    }
}
