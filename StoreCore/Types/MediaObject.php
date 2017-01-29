<?php
namespace StoreCore\Types;

/**
 * Schema.org Media Object
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/MediaObject
 * @version   0.1.0
 */
class MediaObject extends CreativeWork
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'audioobject' => 'AudioObject',
        'datadownload' => 'DataDownload',
        'imageobject' => 'ImageObject',
        'mediaobject' => 'MediaObject',
        'musicvideoobject' => 'MusicVideoObject',
        'videoobject' => 'VideoObject',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('MediaObject');
    }

    /**
     * Set the URL of the actual media file.
     *
     * @param string $content_url
     *   A URL pointing to the actual media file.  All files must be accessible
     *   via HTTP.  Metafiles that require a download of the source via
     *   streaming protocols, such as RTMP, are not supported by Google.
     *
     * @return $this
     */
    public function setContentURL($content_url)
    {
        $content_url = filter_var($content_url, FILTER_VALIDATE_URL);
        if ($content_url === false) {
            throw new \InvalidArgumentException();
        }

        $this->setStringProperty('contentUrl', $content_url);
        return $this;
    }

    /**
     * Set the duration of the item.
     *
     * @param string $duration
     *   The duration of the item (movie, audio recording, event, etc.) in
     *   ISO 8601 date format.
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->setStringProperty('duration', $duration);
        return $this;
    }

    /**
     * Set the URL to embed the media object.
     *
     * @param string $embed_url
     *   A URL pointing to a player for the specific media.  Usually this is
     *   the information in the `src` element of an `<embed>` tag.
     *
     * @return $this
     */
    public function setEmbedUrl($embed_url)
    {
        $embed_url = filter_var($embed_url, FILTER_VALIDATE_URL);
        if ($embed_url === false) {
            throw new \InvalidArgumentException();
        }

        $this->setStringProperty('embedUrl', $embed_url);
        return $this;
    }

    /**
     * Set the URL of a thumbnail image.
     *
     * @param string $thumbnail_url
     * @return $this
     */
    public function setThumbnailURL($thumbnail_url)
    {
        $thumbnail_url = filter_var($thumbnail_url, FILTER_VALIDATE_URL);
        if ($thumbnail_url === false) {
            throw new \InvalidArgumentException();
        }

        $this->setStringProperty('thumbnailUrl', $thumbnail_url);
        return $this;
    }

    /**
     * Set the date the media object was first uploaded.
     *
     * @param DateTime|string $upload_date
     * @return $this
     */
    public function setUploadDate($upload_date)
    {
        $this->setDateProperty('uploadDate', $upload_date);
        return $this;
    }
}
