<?php
namespace StoreCore\FileSystem;

class LogFileManager implements \Countable
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /** @type array|bool $LogFiles */
    private $LogFiles;

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->LogFiles = scandir(STORECORE_FILESYSTEM_LOGS);
        if ($this->LogFiles !== false) {
            $this->clear();
        }
    }

    /**
     * Clear the logs directory.
     *
     * @param bool $all
     *     Delete all log files (true) or only empty log files (default false).
     *
     * @return void
     */
    public function clear($all = false)
    {
        $log_files = $this->LogFiles;
        foreach ($log_files as $key => $filename) {
            if (is_dir(STORECORE_FILESYSTEM_LOGS . $filename)) {
                unset($log_files[$key]);
            } elseif ($filename === '.htaccess') {
                unset($log_files[$key]);
            } else {
                $filename = str_ireplace('.log', null, $filename) . '.log';
                if ($all === true || filesize(STORECORE_FILESYSTEM_LOGS . $filename) === 0) {
                    if (unlink(STORECORE_FILESYSTEM_LOGS . $filename)) {
                        unset($log_files[$key]);
                    }
                }
            }
        }
        $this->LogFiles = $log_files;
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
        } else {
            return count($this->LogFiles);
        }
    }
}
