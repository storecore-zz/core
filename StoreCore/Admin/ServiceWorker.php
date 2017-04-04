<?php
namespace StoreCore\Admin;

/**
 * Service Worker Controller
 *
 * @author    Ward van der Put <ward.vanderput@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class ServiceWorker
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        ob_start('ob_gzhandler');
        header('Content-Type: application/javascript');
        readfile(__DIR__ . DIRECTORY_SEPARATOR . 'ServiceWorker.js');
        exit;
    }
}
