<?php
namespace StoreCore\Admin;

class Document extends \StoreCore\Document
{
    protected $Links = array(
        '1741c37043403bf55945c78410d0bac8' => array(
            'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
            'rel'  => 'stylesheet',
        ),
        '04f1d2ff0d8e68f475342c1bcd041c60' => array(
            'href' => '//fonts.googleapis.com/css?family=Roboto:300,400,500,700,900',
            'rel'  => 'stylesheet',
        ),
        '945633b0695ae97d11f7ce3435b978c7' => array(
            'href' => '/css/admin.min.css',
            'rel'  => 'stylesheet',
        ),
    );

    protected $MetaData = array(
        'generator' => 'StoreCore ' . STORECORE_VERSION,
        'robots' => 'noindex,nofollow',
        'viewport' => 'width=device-width, initial-scale=1',
    );
}
