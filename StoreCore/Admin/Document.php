<?php
namespace StoreCore\Admin;

/**
 * Admin GUI Document
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class Document extends \StoreCore\Document
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * @var array $Links
     */
    protected $Links = array(
        'cbc332749284345c63e87d1e727ae56e' => array(
            'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
            'rel'  => 'stylesheet',
        ),
        '2d783734d8d336832734ba1fe7d4f946' => array(
            'href' => '//fonts.googleapis.com/css?family=Noto+Sans:400,700',
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
        '337e46124a7928fe45d454c01a905414' => array(
            'href' => '/assets/ico/localhost.ico',
            'rel'  => 'shortcut icon',
        ),
    );

    /**
     * @var array $MetaData
     */
    protected $MetaData = array(
        'generator' => 'StoreCore',
        'robots' => 'noindex,nofollow',
        'viewport' => 'width=device-width, initial-scale=1',
    );

    /**
     * @var string $Title
     */
    protected $Title = 'StoreCore';
}
