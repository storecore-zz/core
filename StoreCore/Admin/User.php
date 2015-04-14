<?php
namespace StoreCore\Admin;

class User extends \StoreCore\AbstractController
{
    private $UserGroupID = 0;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);
        $this->Logger = new \StoreCore\FileSystem\Logger();
        $this->Registry->set('Logger', $this->Logger);
    }

    /**
     * @param int $user_group_id
     * @return void
     */
    public function setUserGroup($user_group_id = 0)
    {
        $this->UserGroupID = (int)$user_group_id;
    }

    /**
     * @param void
     * @return void
     */
    public function signOut()
    {
        $session = new \StoreCore\Session();
        $session->destroy();
        $this->Registry->set('Session', null);
        $this->Registry->set('User', null);

        $this->Logger->info('User signing out.');
        sleep(1);
        $response = new \StoreCore\Response($this->Registry);
        $response->redirect('/admin/sign-in/');
        exit;
    }
}
