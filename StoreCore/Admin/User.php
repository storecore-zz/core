<?php
namespace StoreCore\Admin;

/**
 * StoreCore Admin User
 *
 * @author    Ward van der Put <ward@storecore.org>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 *
 * @uses \StoreCore\User
 *   The \StoreCore\Admin\User administration user extends the more generic
 *   \StoreCore\User framework user.
 */
class User extends \StoreCore\User
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Log off the user and destroy the user session.
     *
     * @param void
     * @return void
     */
    public function signOut()
    {
        $session = new \StoreCore\Session();
        $session->destroy();

        if (!defined('STORECORE_NULL_LOGGER') || STORECORE_NULL_LOGGER !== true) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->info(
                'User "' . $this->getUsername()
                . ' (#' . $this->getUserID() . ')'
                . '" signing out.'
            );
        }

        $response = new \StoreCore\Response($this->Registry);
        $response->redirect('/admin/lock/');
        exit;
    }
}
