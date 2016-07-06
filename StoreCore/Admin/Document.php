<?php
namespace StoreCore\Admin;

/**
 * Admin GUI Document
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Document extends \StoreCore\Document
{
    const VERSION = '0.1.0';

    /** @var array $Links */
    protected $Links = array(
        'cf9a7ff54be9109cc67e55353fda8219' => array(
            'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
            'rel'  => 'stylesheet',
        ),
        'dd3333881cfd6d7ac6c08d40315257bf' => array(
            'href' => '//fonts.googleapis.com/css?family=Roboto:300,400,500,700,900',
            'rel'  => 'stylesheet',
        ),
        'cc841a6f8ba105179e457c1c4e60a14e' => array(
            'href' => '//fonts.googleapis.com/icon?family=Material+Icons',
            'rel'  => 'stylesheet',
        ),
        '5963f6c37630f19a97ee8ca328a71656' => array(
            'href' => '/css/mdl-v1.1.3.min.css',
            'rel'  => 'stylesheet',
        ),        
        '945633b0695ae97d11f7ce3435b978c7' => array(
            'href' => '/css/admin.min.css',
            'rel'  => 'stylesheet',
        ),
        '337e46124a7928fe45d454c01a905414' => array(
            'href' => '/assets/ico/localhost.ico',
            'rel'  => 'shortcut icon',
        ),
    );

    /** @var array $MetaData */
    protected $MetaData = array(
        'generator' => 'StoreCore',
        'robots' => 'noindex,nofollow',
        'viewport' => 'width=device-width,initial-scale=1,minimum-scale=1',
        'apple-mobile-web-app-capable' => 'yes',
        'apple-mobile-web-app-status-bar-style' => 'black-translucent',
    );

    /** @var string $Title */
    protected $Title = 'StoreCore';
}
