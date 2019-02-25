<?php
namespace StoreCore\AMP;

use \StoreCore\AMP\LayoutInterface as LayoutInterface;
use \StoreCore\Types\StringableInterface as StringableInterface;

/**
 * Navigation Drawer
 *
 * The navigation drawer provided by this class is one of the main
 * implementations of the AMP HTML `<amp-sidebar>` component.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://material.io/design/components/navigation-drawer.html
 * @see       https://material.io/develop/web/components/drawers/
 * @see       https://github.com/material-components/material-components-web/tree/master/packages/mdc-drawer
 * @version   0.1.0
 */
class Drawer extends Sidebar implements LayoutInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';


    /**
     * @var array $Attributes
     *   AMP HTML attributes of the `<amp-sidebar>` component.  Defaults to
     *   `<amp-sidebar id="drawer" layout="nodisplay" on="tap:drawer.close"
     *   side="left">`.  Please note that the unique DOM object ID is set to
     *   `id="drawer"` for a navigation drawer.
     */
    protected $Attributes = array(
        'id' => 'drawer',
        'layout' => LayoutInterface::LAYOUT_NODISPLAY,
        'on' => 'tap:drawer.close',
        'side'  => 'left',
    );
}
