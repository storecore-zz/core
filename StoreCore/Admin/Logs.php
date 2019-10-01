<?php
namespace StoreCore\Admin;

use StoreCore\AbstractController;
use StoreCore\Registry;
use StoreCore\ResponseFactory;

/**
 * Logs
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015-2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Logs extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /** @var \StoreCore\FileSystem\LogFileManager $Model */
    private $Model;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     * @uses \StoreCore\FileSystem\LogFileManager
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);
        $this->Model = new LogFileManager();
    }

    /**
     * Download all log files combined to a single text file.
     *
     * @param void
     * @return void
     */
    public function download()
    {
        $download = $this->read();
        if ($download === null) {
            header('HTTP/1.1 204 No Content', true);
            exit;
        }

        $filename = date('Y-m-d-H-i-s') . '.txt';
        $download = implode(PHP_EOL, $download);

        $factory = new ResponseFactory();
        $response = $factory->createResponse();

        $response->addHeader('Content-Type: text/plain; charset=UTF-8');
        $response->addHeader('Content-Disposition: attachment; filename="' . $filename . '"');
        $response->setCompression(false);
        $response->setResponseBody($download);
        $response->output();
    }

    /**
     * Read all log files.
     *
     * @param void
     * @return array|null
     */
    public function read()
    {
        $return = $this->Model->read();
        if ($return === null) {
            return null;
        }

        $return = str_ireplace("\r\n", "\n", $return);
        $return = explode("\n", $return);
        arsort($return);
        return $return;
    }
}
