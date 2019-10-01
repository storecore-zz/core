<?php
namespace StoreCore\Admin;

use StoreCore\ResponseFactory;
use StoreCore\Session;

use StoreCore\FileSystem\Logger;

/**
 * StoreCore Admin User
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015-2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 *
 * @uses \StoreCore\User
 *   The \StoreCore\Admin\User administration user extends the more generic
 *   \StoreCore\User framework user.
 */
class User extends \StoreCore\User
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Sign out an admin user.
     *
     * Log off the user by destroying the user session, log the activity,
     * and redirect the client to a lock screen.
     *
     * @param void
     * @return void
     */
    public function signOut()
    {
        $session = new Session();
        $session->destroy();

        if (!defined('STORECORE_NULL_LOGGER') || STORECORE_NULL_LOGGER !== true) {
            $logger = new Logger();
            $logger->info(
                'User "' . $this->getUsername()
                . ' (#' . $this->getUserID() . ')'
                . '" signing out.'
            );
        }

        $factory = new ResponseFactory();
        $response = $factory->createResponse(303);
        $response->redirect('/admin/lock/');
        exit;
    }
}
