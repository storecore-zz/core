<?php
namespace StoreCore\Admin;

use StoreCore\AbstractController;
use StoreCore\Database\Whitelist;

/**
 * Access Control Whitelist Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class AccessControlWhitelist extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Check if an IP address is whitelisted for admin access.
     *
     * @param void
     * 
     * @return void
     *
     * @uses \StoreCore\Database\Whitelist::isEmpty()
     *   First test if there are any active whitelisted admin IP addresses.
     *   This check assumes the whitelist is not used, or can no longer
     *   be used, if it currently has no active entries.
     * 
     * @uses \StoreCore\Database\Whitelist::administratorExists()
     *   Check if the currently whitelisted IP address has admin access.
     */
    public function check()
    {
        $whitelist = new Whitelist($this->Registry);

        if ($whitelist->isEmpty()) {
            return;
        }

        if ($whitelist->exists($this->Server->getRemoteAddress(), true)) {
            return;
        }

        $this->Database = null;
        $this->Logger->warning('Whitelist access denied to remote IP address ' . $this->Server->getRemoteAddress() . '.');
        header('Not Found', true, 404);
        exit;
    }
}
