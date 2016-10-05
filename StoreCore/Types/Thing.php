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
