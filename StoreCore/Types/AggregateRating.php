<?php
namespace StoreCore\Types;

/**
 * Schema.org Aggregate Rating
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/AggregateRating
 * @version   0.1.0
 */
class AggregateRating extends Rating
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('AggregateRating');
    }

    /**
     * Set the item that is being reviewed or rated.
     *
     * @param \StoreCore\Types\Thing $thing
     * @return $this
     */
    public function setItemReviewed(Thing $thing)
    {
        $this->Data['itemReviewed'] = $thing;
        return $this;
    }

    /**
     * Set the total number of ratings.
     *
     * @param int $rating_count
     *   The count of total number of ratings.
     *
     * @return $this
     */
    public function setRatingCount($rating_count)
    {
        $this->Data['ratingCount'] = $rating_count;
        return $this;
    }

    /**
     * Set the total number of reviews.
     *
     * @param int $review_count
     *   The count of total number of reviews.
     *
     * @return $this
     */
    public function setReviewCount($review_count)
    {
        $this->Data['reviewCount'] = $review_count;
        return $this;
    }
}
