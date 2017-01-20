<?php
namespace StoreCore\FileSystem;

/**
 * Log File Manager
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class LogFileManager implements \Countable
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /** @var array|bool $LogFiles */
    private $LogFiles;

    /**
     * @param void
     * @return self
     */
    public function __construct()
    {
        $this->LogFiles = scandir(STORECORE_FILESYSTEM_LOGS_DIR);
        if ($this->LogFiles !== false) {
            $this->clear();
        }
    }

    /**
     * Clear the logs directory.
     *
     * @param bool $all
     *   Delete all log files (true) or only empty log files (default false).
     *
     * @return void
     */
    public function clear($all = false)
    {
        $files = $this->LogFiles;
        foreach ($files as $key => $filename) {
            if (is_dir(STORECORE_FILESYSTEM_LOGS_DIR . $filename)) {
                unset($files[$key]);
            } elseif ($filename === '.htaccess') {
                unset($files[$key]);
            } else {
                $filename = str_ireplace('.log', null, $filename) . '.log';
                if ($all === true || filesize(STORECORE_FILESYSTEM_LOGS_DIR . $filename) === 0) {
                    if (unlink(STORECORE_FILESYSTEM_LOGS_DIR . $filename)) {
                        unset($files[$key]);
                    }
                }
            }
        }
        $this->LogFiles = $files;
    }

    /**
     * Count the number of log files.
     *
     * @param void
     * @return int
     */
    public function count()
    {
        if (!is_array($this->LogFiles)) {
            return 0;
        }
        return count($this->LogFiles);
    }

    /**
     * Read all log files in descending order by date.
     *
     * @param void
     * @return string|null
     */
    public function read()
    {
        $files = $this->LogFiles;
        if (!is_array($files)) {
            return null;
        }
        arsort($files);

        $return = (string)null;
        foreach ($files as $filename) {
            $file_contents = file_get_contents(STORECORE_FILESYSTEM_LOGS_DIR . $filename, false);
            if ($file_contents !== false && !empty($file_contents)) {
                $return .= $file_contents . "\n";
            }
        }

        $return = str_ireplace("\r\n", "\n", $return);
        $return = str_ireplace("\n\n", "\n", $return);

        if (empty($return)) {
            return null;
        } else {
            return rtrim($return);
        }
    }
}
