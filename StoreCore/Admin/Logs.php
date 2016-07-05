<?php
namespace StoreCore\Admin;

/**
 * Logs
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Logs extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

    /** @var \StoreCore\FileSystem\LogFileManager $Model */
    private $Model;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     * @uses \StoreCore\FileSystem\LogFileManager
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $this->Model = new \StoreCore\FileSystem\LogFileManager();
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

        $response = new \StoreCore\Response($this->Registry);
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
