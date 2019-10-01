<?php
namespace StoreCore\Types;

/**
 * Schema.org Rating
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Rating
 * @version   0.1.0
 */
class Rating extends Intangible
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
        $this->setWorstRating(1);
        $this->setBestRating(5);
        if ($rating_value !== null) {
            $this->setRatingValue($rating_value);
        }
    }

    /**
     * Set the author of a rating.
     *
     * @param Organization|Person|string $author
     *
     * @return void
     *
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
    }

    /**
     * Set the highest allowed rating.
     *
     * @param int|string $best_rating
     *   The highest value allowed in current rating system.  If the
     *    `bestRating` property is omitted, 5 is assumed in Schema.org.
     *
     * @return void
     */
    public function setBestRating($best_rating)
    {
        $this->Data['bestRating'] = $best_rating;
    }

    /**
     * Set the current rating.
     *
     * @param int|string $rating_value
     *
     * @return void
     */
    public function setRatingValue($rating_value)
    {
        $this->Data['ratingValue'] = $rating_value;
    }

    /**
     * Set the lowest allowed rating.
     *
     * @param int|string $worst_rating
     *   The lowest value allowed in the current rating system.  If the
     *   `worstRating` property is omitted, 1 is assumed in Schema.org.
     *
     * @return void
     */
    public function setWorstRating($worst_rating)
    {
        $this->Data['worstRating'] = $worst_rating;
    }
}
