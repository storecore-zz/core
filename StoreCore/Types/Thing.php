<?php
namespace StoreCore\Types;

/**
 * Schema.org Thing
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Thing
 * @version   0.1.0
 */
class Thing extends AbstractRichSnippet
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'action' => 'Action',
        'creativework' => 'CreativeWork',
        'event' => 'Event',
        'intangible' => 'Intangible',
        'organisation' => 'Organization',
        'organization' => 'Organization',
        'person' => 'Person',
        'place' => 'Place',
        'product' => 'Product',
    );

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
        } else {
            return null;
        }
    }

    /**
     * Set the alternate name of an item.
     *
     * @param string $alternate_name
     * @return $this
     */
    public function setAlternateName($alternate_name)
    {
        $this->setStringProperty('alternateName', $alternate_name);
        return $this;
    }

    /**
     * Set a description of the item.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setStringProperty('description', $description);
        return $this;
    }

    /**
     * Set an image of the item.
     *
     * @param ImageObject|string $image
     *   An image of the item.  This can be a URL or a fully described
     *   Schema.org ImageObject.
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->Data['image'] = $image;
        return $this;
    }

    /**
     * Set the name and alternate name of an item.
     *
     * @param string $name
     *   The name of the item.
     *
     * @param string $alternate_name
     *   An optional alias for the item.
     *
     * @return $this
     */
    public function setName($name, $alternate_name = null)
    {
        $this->setStringProperty('name', $name);

        if (
            $alternate_name !== null
            && strtolower($alternate_name) != strtolower($name)
        ) {
            $this->setAlternateName($alternate_name);
        }

        return $this;
    }

    /**
     * Set a potential action on the item.
     *
     * @param \StoreCore\Types\Action $action
     * @return $this
     */
    public function setPotentialAction(Action $action)
    {
        $action = (string)$action;
        $this->Data['potentialAction'] = $action;
        return $this;
    }

    /**
     * Add an alternate URL for the item.
     *
     * @param string $same_as
     *   URL of a reference web page that unambiguously indicates the item's
     *   identity, for example the URL of the item's Wikipedia page.
     *   Google supports this property for these types of social profiles:
     *   Facebook, Twitter, Google+, Instagram, YouTube, LinkedIn, Myspace
     *   Pinterest, SoundCloud, and Tumblr.  You MAY specify other social
     *   profiles as well, but they aren't currently included in Google Search
     *   results.
     *
     * @return $this
     *
     * @see https://developers.google.com/search/docs/data-types/social-profile-links
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the $same_as argument
     *   is not a string or an empty string.  This method currently does not
     *   check if the argument is a valid URL nor does it check if the URL
     *   exists.
     */
    public function setSameAs($same_as)
    {
        if (!is_string($same_as)) {
            throw new \InvalidArgumentException();
        }

        $same_as = trim($same_as);
        if (empty($same_as)) {
            throw new \InvalidArgumentException();
        }

        // Handle single property as a string and multiple properties as an array.
        if (!array_key_exists('sameAs', $this->Data)) {
            $this->Data['sameAs'] = $same_as;
        } elseif (is_string($this->Data['sameAs'])) {
            $this->Data['sameAs'] = array($this->Data['sameAs'], $same_as);
        } else {
            $this->Data['sameAs'][] = $same_as;
        }
        return $this;
    }

    /**
     * Set the URL of the item.
     *
     * @param string $url
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setURL($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException();
        }

        $url = trim($url);
        $url = filter_var($url, FILTER_VALIDATE_URL);
        if (false == $url) {
            throw new \InvalidArgumentException();
        }

        $this->Data['url'] = $url;
        return $this;
    }
}
