<?php
namespace StoreCore\Admin;

/**
 * StoreCore Admin User
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.0.1
 *
 * @uses \StoreCore\User
 *     The \StoreCore\Admin\User administration user extends the more
 *     generic \StoreCore\User framework user.
 */
class User extends \StoreCore\User
{
    /** @var string VERSION */
    const VERSION = '0.0.1';

    /**
     * @param void
     * @return void
     */
    public function signOut()
    {
        $session = new \StoreCore\Session();
        $session->destroy();

        $logger = new \StoreCore\FileSystem\Logger();
        $logger->info('User "' . $this->$Username . '" signing out.');

        $response = new \StoreCore\Response($this->Registry);
        $response->redirect('/admin/lock/');
        exit;
    }
}
