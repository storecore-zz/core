<?php
namespace StoreCore\Admin;

class LockScreen extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';
    
    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $html
            = '<div class="lock-screen">'
            . '<h1><strong>Store</strong>Core<sup>™</sup></h1>'
            . '<p><a href="/admin/sign-in/" target="_top">' . \STORECORE\I18N\COMMAND_UNLOCK . '</a></p>'
            . '</div>';
            
        $lock_screen = new \StoreCore\Admin\Document();
        $lock_screen->setTitle('StoreCore™');
        $lock_screen->addSection($html, '');

        $response = new \StoreCore\Response($this->Registry);
        $response->setResponseBody($lock_screen);
        $response->output();
    }
}
