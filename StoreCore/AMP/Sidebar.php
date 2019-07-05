<?php
namespace StoreCore\AMP;

use \StoreCore\AMP\LayoutInterface as LayoutInterface;
use \StoreCore\Types\StringableInterface as StringableInterface;

/**
 * AMP Sidebar Component <amp-sidebar>
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://amp.dev/documentation/components/amp-sidebar
 * @see       https://amp.dev/documentation/examples/components/amp-sidebar/
 * @version   0.1.0
 */
class Sidebar extends AbstractComponent implements LayoutInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';


    /**
     * @var array $Attributes
     *   AMP HTML attributes of the `<amp-sidebar>` component.  Defaults to
     *   `<amp-sidebar layout="nodisplay" side="left">`.
     */
    protected $Attributes = array(
        'layout' => LayoutInterface::LAYOUT_NODISPLAY,
        'side'  => 'left',
    );

    /**
     * @inheritDoc
     */
    protected $SupportedLayouts = array(
        LayoutInterface::LAYOUT_NODISPLAY,
    );


    /**
     * Convert the <amp-sidebar> component to a string.
     *
     * @param void
     *
     * @return string
     *   Returns the AMP HTML component `<amp-sidebar>…</amp-sidebar>` as a
     *   string with attributes and contents.
     */
    public function __toString()
    {
        $html = '<amp-sidebar';
        foreach ($this->Attributes as $attribute => $value) {
            $html .= ' ' . $attribute . '="' . $value . '"';
        }
        $html .= '>';

        foreach ($this->Children as $child) {
            $html .= $child;
        }

        $html .= '</amp-sidebar>';

        return $html;
    }
}
