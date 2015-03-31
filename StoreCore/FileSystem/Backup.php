<?php
namespace StoreCore\FileSystem;

use \StoreCore\FileSystem\Logger as Logger;

class Backup
{
    const VERSION = '0.0.1';

    public function __construct($compress = true)
    {

        $logger = new Logger();
        $logger->notice('Backup process started');

        $working_directory = getcwd();
        if ($working_directory == false || !is_writable($working_directory)) {
            $logger->error('Current working directory is not writeable');
            throw new \RuntimeException('Current working directory is not writeable');
        }

        $archive_filename = $working_directory . DIRECTORY_SEPARATOR . 'backup-' . date('Y-m-d-H-m-s') . '.tar';
        $archive = new \PharData($archive_filename);
        $archive->buildFromDirectory($working_directory);
        $logger->notice('Backup saved as ' . $archive_filename);

        if ($compress !== false) {
            $archive->compress(\Phar::GZ);
            $logger->notice('Backup compressed to ' . $archive_filename . '.gz');
            if (!unlink($archive_filename)) {
                $logger->error('Could not delete the archive file ' . $archive_filename);
            }
        }
    }
}
