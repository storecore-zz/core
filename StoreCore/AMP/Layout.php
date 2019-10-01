<?php
namespace StoreCore\AMP;

/**
 * AMP Layout Component <amp-layout>
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://amp.dev/documentation/components/amp-layout
 * @version   0.1.0
 */
class Layout extends AbstractComponent implements LayoutInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $Attributes
     *   HTML and AMP attributes of the `<amp-layout>` component.  Defaults to
     *   `<amp-layout height="1" layout="responsive" width="1">`.
     */
    protected $Attributes = array(
        'height' => 1,
        'layout' => LayoutInterface::LAYOUT_RESPONSIVE,
        'width'  => 1,
    );

    /**
     * @inheritDoc
     */
    protected $SupportedLayouts = array(
        LayoutInterface::LAYOUT_CONTAINER,
        LayoutInterface::LAYOUT_FILL,
        LayoutInterface::LAYOUT_FIXED,
        LayoutInterface::LAYOUT_FIXED_HEIGHT,
        LayoutInterface::LAYOUT_FLEX_ITEM,
        LayoutInterface::LAYOUT_INTRINSIC,
        LayoutInterface::LAYOUT_RESPONSIVE,
    );

    /**
     * Convert the <amp-layout> component to a string.
     *
     * @param void
     *
     * @return string
     *   Returns the AMP HTML component `<amp-layout>…</amp-layout>` as a
     *   string with attributes and contents.
     */
    public function __toString()
    {
        $str = '<amp-layout';
        foreach ($this->Attributes as $attribute => $value) {
            $str .= ' ' . $attribute . '="' . $value . '"';
        }
        $str .= '>';

        foreach ($this->Children as $child) {
            $str .= $child;
        }

        $str .= '</amp-layout>';

        return $str;
    }
}
