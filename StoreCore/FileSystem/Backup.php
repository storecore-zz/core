<?php
namespace StoreCore\FileSystem;

/**
 * StoreCore File System Backup
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Backup
{
    /** @var string VERSION */
    const VERSION = '0.1.0';

    /**
     * Save a file system backup to a (compressed) archive file.
     *
     * @param $compress
     *   Compress the archive to .tar.gz (default true) or do not compress the
     *   .tar archive (false).
     *
     * @return void
     *
     * @throws \RuntimeException
     *   An SPL (Standard PHP Library) runtime exception is thrown if the current working directory
     *   is not writeable.
     */
    public static function save($compress = true)
    {
        if (STORECORE_NULL_LOGGER) {
            $logger = new \Psr\Log\NullLogger();
        } else {
            $logger = new \StoreCore\FileSystem\Logger();
        }
        $logger->notice('Backup process started.');

        $working_directory = getcwd();
        if ($working_directory == false || !is_writable($working_directory)) {
            $logger->error('Current working directory is not writeable.');
            throw new \RuntimeException('Current working directory is not writeable.');
        }

        $archive_filename = $working_directory . DIRECTORY_SEPARATOR . 'backup-' . gmdate('Y-m-d-H-m-s') . '-UTC-' . time() . '.tar';
        $archive = new \PharData($archive_filename);
        $archive->buildFromDirectory($working_directory);
        $logger->notice('File system backup saved as ' . $archive_filename . '.');

        if ($compress != false) {
            $archive->compress(\Phar::GZ);
            $logger->notice('Backup compressed to ' . $archive_filename . '.gz.');
            $archive = null;
            if (!unlink($archive_filename)) {
                $logger->error('Could not delete the archive file ' . $archive_filename . '.');
            }
        }
    }
}
