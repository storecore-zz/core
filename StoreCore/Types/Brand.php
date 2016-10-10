<?php
namespace StoreCore\Types;

/**
 * Schema.org Brand
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Brand
 * @version   0.1.0
 */
class Brand extends Intangible
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'brand' => 'Brand',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Brand');
    }

    /**
     * Set the overall rating of the brand.
     *
     * @param AggregateRating $aggregate_rating
     * @return $this
     */
    public function setAggregateRating(AggregateRating $aggregate_rating)
    {
        $this->Data['aggregateRating'] = $aggregate_rating;
        return $this;
    }

    /**
     * Set the brand logo.
     *
     * @param ImageObject|string
     *   The fully-qualified URL of the logo image file or an ImageObject.
     *
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->Data['logo'] = $logo;
        return $this;
    }
}
