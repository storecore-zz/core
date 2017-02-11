<?php
namespace StoreCore\Types;

/**
 * Schema.org Review
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Review
 * @version   0.1.0
 */
class Review extends CreativeWork
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'claimreview' => 'ClaimReview',
        'review' => 'Review',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Review');
    }

    /**
     * Set the reviewed item.
     *
     * @param Thing $item_reviewed
     * @return $this
     */
    public function setItemReviewed(Thing $item_reviewed)
    {
        $this->Data['itemReviewed'] = $item_reviewed;
        return $this;
    }

    /**
     * Set the text of the review.
     *
     * @param string $review_body
     * @return $this
     */
    public function setReviewBody($review_body)
    {
        $this->setStringProperty('reviewBody', $review_body);
        return $this;
    }

    /**
     * Set the rating given in this review.
     *
     * @param Rating $review_rating
     *   The rating given in this review.  Note that reviews can themselves be
     *   rated.  The `reviewRating` applies to rating given by the review.  The
     *   `aggregateRating` applies to the review itself, as a creative work.
     *
     * @return $this
     */
    public function setReviewRating(Rating $review_rating)
    {
        $this->Data['reviewRating'] = $review_rating;
        if (
            !array_key_exists('author', $this->Data)
            && $review_rating->author !== null
        ) {
            $this->Data['author'] = $review_rating->author;
        }
        return $this;
    }
}
