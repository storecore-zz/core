<?php
namespace StoreCore\Admin;

use \StoreCore\AbstractController as AbstractController;

/**
 * Access Control Whitelist Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class AccessControlWhitelist extends AbstractController
{
    const VERSION = '0.1.0';

    /**
     * @param void
     * @return void
     */
    public function check()
    {
        $model = new \StoreCore\Database\AccessControlWhitelist($this->Registry);

        // Check if the whitelist is usable.
        if ($model->count() === 0) {
            return;
        }

        if (
            isset($_SERVER['REMOTE_ADDR'])
            && $model->administratorExists($_SERVER['REMOTE_ADDR'])
        ) {
            return;
        }

        $this->Logger->warning('Whitelist access denied to remote IP address ' . $_SERVER['REMOTE_ADDR'] . '.');
        header('HTTP/1.1 404 Not Found', true);
        exit;
    }
}
