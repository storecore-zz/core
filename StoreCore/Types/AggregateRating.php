<?php
namespace StoreCore\Types;

/**
 * Schema.org Aggregate Rating
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/AggregateRating
 * @version   0.1.0
 */
class AggregateRating extends Rating
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
        $this->setType('AggregateRating');
    }

    /**
     * Set the item that is being reviewed or rated.
     *
     * @param \StoreCore\Types\Thing $thing
     *
     * @return void
     */
    public function setItemReviewed(Thing $thing)
    {
        $this->Data['itemReviewed'] = $thing;
    }

    /**
     * Set the total number of ratings.
     *
     * @param int $rating_count
     *   The count of total number of ratings.
     *
     * @return void
     */
    public function setRatingCount($rating_count)
    {
        $this->Data['ratingCount'] = $rating_count;
    }

    /**
     * Set the total number of reviews.
     *
     * @param int $review_count
     *   The count of total number of reviews.
     *
     * @return void
     */
    public function setReviewCount($review_count)
    {
        $this->Data['reviewCount'] = $review_count;
    }
}
