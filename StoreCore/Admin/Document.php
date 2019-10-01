<?php
namespace StoreCore\Admin;

use \StoreCore\Types\StringableInterface as StringableInterface;
use \StoreCore\Types\Link as Link;

/**
 * Admin GUI Document
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Document extends \StoreCore\Document implements StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $MetaData
     *   Document meta data for `<meta name="…" value="…">` tags.
     */
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

    /**
     * @var string $Title
     *   Document title, defaults to the app name StoreCore.
     */
    protected $Title = 'StoreCore';

    /**
     * @inheritDoc
     */
    public function __construct($title = 'StoreCore')
    {
        parent::__construct($title);

        // DNS prefetch
        $this->addLink(new Link('https://fonts.googleapis.com/', 'dns-prefetch'));
        $this->addLink(new Link('https://fonts.gstatic.com/', 'dns-prefetch'));
        $this->addLink(new Link('https://unpkg.com/', 'dns-prefetch'));

        // Web app manifest
        $this->addLink(new Link('/admin/StoreCore.webmanifest', 'manifest'));

        // Theme styling
        $this->addLink(new Link('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900', 'stylesheet'));
        $this->addLink(new Link('https://fonts.googleapis.com/icon?family=Material+Icons', 'stylesheet'));
        $this->addLink(new Link('/styles/admin.min.css', 'stylesheet'));
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return
            '<body class="mdc-typography">'
            . implode($this->Sections)
            . '</body>';
    }
}
