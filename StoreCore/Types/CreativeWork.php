<?php
namespace StoreCore\Types;

/**
 * Schema.org Creative Work
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/CreativeWork
 * @version   0.1.0
 */
class CreativeWork extends Thing
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'article' => 'Article',
        'blog' => 'Blog',
        'book' => 'Book',
        'clip' => 'Clip',
        'comment' => 'Comment',
        'conversation' => 'Conversation',
        'creativework' => 'CreativeWork',
        'creativeworkseason' => 'CreativeWorkSeason',
        'creativeworkseries' => 'CreativeWorkSeries',
        'datacatalog' => 'DataCatalog',
        'dataset' => 'Dataset',
        'digitaldocument' => 'DigitalDocument',
        'episode' => 'Episode',
        'game' => 'Game',
        'map' => 'Map',
        'mediaobject' => 'MediaObject',
        'message' => 'Message',
        'movie' => 'Movie',
        'musiccomposition' => 'MusicComposition',
        'musicplaylist' => 'MusicPlaylist',
        'musicrecording' => 'MusicRecording',
        'painting' => 'Painting',
        'photograph' => 'Photograph',
        'publicationissue' => 'PublicationIssue',
        'publicationvolume' => 'PublicationVolume',
        'question' => 'Question',
        'recipe' => 'Recipe',
        'review' => 'Review',
        'sculpture' => 'Sculpture',
        'series' => 'Series',
        'softwareapplication' => 'SoftwareApplication',
        'softwaresourcecode' => 'SoftwareSourceCode',
        'tvseason' => 'TVSeason',
        'tvseries' => 'TVSeries',
        'visualartwork' => 'VisualArtwork',
        'webpage' => 'WebPage',
        'webpageelement' => 'WebPageElement',
        'website' => 'WebSite',
    );

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->setType('CreativeWork');
        $this->setSchemaVersion('http://schema.org/version/3.1/');
    }

    /**
     * Set the aggregate rating.
     *
     * @param AggregateRating $aggregate_rating
     *   The overall rating, based on a collection of reviews or ratings, of
     *   the item.
     *
     * @return $this
     */
    public function setAggregateRating(AggregateRating $aggregate_rating)
    {
        $this->Data['aggregateRating'] = $aggregate_rating;
        return $this;
    }

    /**
     * Set the author of the creative work.
     *
     * @param Person|Organization $author
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setAuthor($author)
    {
        if ($author instanceof Person || $author instanceof Organization) {
            $this->Data['author'] = $author;
        } else {
            throw new \InvalidArgumentException();
        }
        return $this;
    }

    /**
     * Indicate whether this content is family friendly.
     *
     * @param bool $is_family_friendly
     * @return $this
     */
    public function setIsFamilyFriendly($is_family_friendly = true)
    {
        $this->setProperty('isFamilyFriendly', (bool)$is_family_friendly);
        return $this;
    }

    /**
     * Set or add keywords and tags.
     *
     * @param string $keywords
     *   Keywords or tags used to describe this content.  Multiple entries in
     *   a keywords list are typically delimited by commas.  This method MAY
     *   be called repeatedly to add new keywords or tags to an existing
     *   keywords list; possible duplicates will then be removed.
     *
     * @return $this
     */
    public function setKeywords($keywords)
    {
        if (array_key_exists('keywords', $this->Data)) {
            $keywords = $this->Data['keywords'] . ', ' . $keywords;
        }

        $keywords = explode(',', $keywords);
        foreach ($keywords as $key => $keyword) {
            $keyword = trim($keyword);
            if (empty($keyword)) {
                unset($keywords[$key]);
            } else {
                $keywords[$key] = $keyword;
            }
        }

        // Remove duplicate keywords.
        $keywords = array_unique($keywords);

        $keywords = implode(', ', $keywords);
        $this->Data['keywords'] = $keywords;
        return $this;
    }

    /**
     * Set the schema version.
     *
     * @param string $schema_version
     *   URL or string that indicates a particular version of a schema used in
     *   some CreativeWork.  For example, a document could declare a
     *   schema version using an URL such as http://schema.org/version/2.0/ if
     *   precise indication of schema version was required by some application.
     *
     * @return $this
     *
     * @see http://schema.org/docs/releases.html
     */

    public function setSchemaVersion($schema_version)
    {
        $this->setStringProperty('schemaVersion', $schema_version);
        return $this;
    }
}
