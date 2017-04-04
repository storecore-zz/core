<?php
namespace StoreCore\Admin;

/**
 * Admin GUI Document
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Document extends \StoreCore\Document
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var array $Links
     *   Associative array for `<link href="..." rel="...">` elements in the
     *   `<head>...</head>` container of the HTML document.
     */
    protected $Links = array(
        '6bb60c2b4cfa0d26fdf447532e52fc57' => array(
            'href' => 'https://fonts.googleapis.com/',
            'rel'  => 'dns-prefetch',
        ),
        '106719df5730b22f08dfb83570eee34a' => array(
            'href' => '/admin/StoreCore.webmanifest',
            'rel'  => 'manifest',
        ),
        '7ed8cc1d36d9a43dbf5600109929dfb7' => array(
            'href' => 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
            'rel'  => 'stylesheet',
        ),
        '6a587e585353b2665a22578ba309fc08' => array(
            'href' => 'https://fonts.googleapis.com/css?family=Roboto:900&amp;text=Store',
            'rel'  => 'stylesheet',
        ),
        'cc841a6f8ba105179e457c1c4e60a14e' => array(
            'href' => 'https://fonts.googleapis.com/icon?family=Material+Icons',
            'rel'  => 'stylesheet',
        ),
        'fca76663bda87f7b798a60664a2114da' => array(
            'href' => '/styles/admin.min.css',
            'rel'  => 'stylesheet',
        ),
    );

    /** @var array $MetaData */
    protected $MetaData = array(
        'generator' => 'StoreCore',
        'robots' => 'noindex,nofollow',
        'viewport' => 'width=device-width,initial-scale=1,minimum-scale=1',
        'apple-mobile-web-app-capable' => 'yes',
        'apple-mobile-web-app-status-bar-style' => 'black-translucent',
        'msapplication-TileColor' => '#8bc34a',
        'msapplication-TileImage' => '/images/StoreCore-icon-144x144.png',
        'theme-color' => '#689f38',
    );

    /** @var string $Title */
    protected $Title = 'StoreCore';
}
