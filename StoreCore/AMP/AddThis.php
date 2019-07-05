<?php
namespace StoreCore\AMP;

use \StoreCore\AMP\LayoutInterface as LayoutInterface;
use \StoreCore\Types\StringableInterface as StringableInterface;

/**
 * AMP AddThis <amp-addthis>
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://amp.dev/documentation/components/amp-addthis
 * @see       https://www.addthis.com/academy/how-to-install-addthis-inline-share-buttons-on-amp-accelerated-mobile-pages/
 * @see       https://blog.amp.dev/2018/07/30/addthis-is-now-available-for-amp/
 * @version   0.1.0
 */
class AddThis extends AbstractComponent implements LayoutInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @param array $Attributes
     *   HTML5 and AMP HTML attributes of the component.
     */
    protected $Attributes = array(
        'height' => 48,
        'layout' => LayoutInterface::LAYOUT_RESPONSIVE,
        'width' => 48,
    );

    /**
     * Construct an AMP component for AddThis
     *
     * @param string|null $publisher_id
     *   Optional AddThis publisher ID.
     *
     * @param string|null $widget_id
     *   Optional AddThis widget ID.
     *
     * @return self
     */
    public function __construct($publisher_id = null, $widget_id = null)
    {
        if ($publisher_id !== null) {
            $this->setPublisherID($publisher_id);
        }

        if ($widget_id !== null) {
            $this->setWidgetID($widget_id);
        }
    }

    /**
     * Convert the AMP AddThis component to AMP HTML.
     *
     * @param void
     *
     * @return string
     *   Returns the `<amp-addthis …></amp-addthis>` component with its
     *   attributes as an HTML string.
     */
    public function __toString()
    {
        $string = '<amp-addthis';
        foreach ($this->Attributes as $attribute => $value) {
            $string .= ' ' . $attribute . '="' . $value . '"';
        }
        $string .= '></amp-addthis>';
        return $string;
    }

    /**
     * Set the AddThis publisher ID.
     *
     * @param string $publisher_id
     *   AddThis publisher identifier for the `data-pub-id` attribute.
     *
     * @return void
     */
    public function setPublisherID($publisher_id)
    {
        $this->Attributes['data-pub-id'] = $publisher_id;
    }

    /**
     * Set the AddThis widget ID.
     *
     * @param string $widget_id
     *   AddThis widget identifier for the `data-widget-id` attribute.
     *
     * @return void
     */
    public function setWidgetID($widget_id)
    {
        $this->Attributes['data-widget-id'] = $widget_id;
    }
}
