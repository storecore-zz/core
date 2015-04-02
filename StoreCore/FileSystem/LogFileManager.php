<?php
namespace StoreCore\FileSystem;

class LogFileManager
{
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
     * @param bool $all
     * @return void
     */
    public function clear($all = false)
    {
        $log_files = $this->LogFiles;
        foreach ($log_files as $key => $filename) {
            if (is_dir(STORECORE_FILESYSTEM_LOGS . $filename)) {
                unset($log_files[$key]);
            } elseif (filesize(STORECORE_FILESYSTEM_LOGS . $filename) === 0) {
                unlink(STORECORE_FILESYSTEM_LOGS . $filename);
                unset($log_files[$key]);
            }
        }
    }
}
