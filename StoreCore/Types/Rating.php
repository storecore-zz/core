<?php
namespace StoreCore\Types;

/**
 * Schema.org Rating
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Rating
 * @version   0.1.0
 */
class Rating extends Intangible
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'aggregaterating' => 'AggregateRating',
        'rating' => 'Rating',
    );

    /**
     * @param int|string|null $rating_value
     * @return void
     * @uses \StoreCore\Types\AbstractRichSnippet::setType()
     * @uses \StoreCore\Types\Rating::setWorstRating()
     * @uses \StoreCore\Types\Rating::setBestRating()
     * @uses \StoreCore\Types\Rating::setRatingValue()
     */
    public function __construct($rating_value = null)
    {
        $this->setType('Rating');
        $this->setWorstRating(1)->setBestRating(5);
        if ($rating_value !== null) {
            $this->setRatingValue($rating_value);
        }
    }

    /**
     * Set the author of a rating.
     *
     * @param Organization|Person|string $author
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->Data['author'] = $author;
        } elseif ($author instanceof Organization || $author instanceof Person) {
            $this->Data['author'] = $author->getName();
        } else {
            throw new \InvalidArgumentException();
        }
        return $this;
    }

    /**
     * Set the highest allowed rating.
     *
     * @param int|string $best_rating
     *   The highest value allowed in current rating system.  If the bestRating
     *   property is omitted, 5 is assumed in Schema.org.
     *
     * @return $this
     */
    public function setBestRating($best_rating)
    {
        $this->Data['bestRating'] = $best_rating;
        return $this;
    }

    /**
     * Set the current rating.
     *
     * @param int|string $rating_value
     * @return $this
     */
    public function setRatingValue($rating_value)
    {
        $this->Data['ratingValue'] = $rating_value;
        return $this;
    }

    /**
     * Set the lowest allowed rating.
     *
     * @param int|string $worst_rating
     *   The lowest value allowed in the current rating system.  If the
     *   worstRating property is omitted, 1 is assumed in Schema.org.
     *
     * @return $this
     */
    public function setWorstRating($worst_rating)
    {
        $this->Data['worstRating'] = $worst_rating;
        return $this;
    }
}
