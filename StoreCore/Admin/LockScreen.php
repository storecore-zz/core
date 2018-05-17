<?php
namespace StoreCore\Admin;

/**
 * Admin Lock Screen
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class LockScreen extends \StoreCore\AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Construct the lock screen.
     *
     * @param \StoreCore\Registry $registry
     *   Global StoreCore service locator.
     *
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        if (!defined('STORECORE\I18N\COMMAND_UNLOCK')) {
            define('STORECORE\I18N\COMMAND_UNLOCK', 'Unlock…');
        }

        $html
            = '<div class="sc-lock-screen">'
            . '<h1 class="sc-logo">'
            . '<strong>Store</strong>Core'
            . '<br>'
            . '<a class="sc-unlock-link" href="/admin/sign-in/" target="_top">'
            . \STORECORE\I18N\COMMAND_UNLOCK
            . '</a>'
            . '</h1>'
            . '</div>';

        $lock_screen = new \StoreCore\Admin\Document();
        $lock_screen->setTitle('StoreCore™');
        $lock_screen->addSection($html, '');

        $response = new \StoreCore\Response($this->Registry);
        $response->addHeader('X-Robots-Tag: noindex');
        $response->setResponseBody($lock_screen);
        $response->output();
    }
}
