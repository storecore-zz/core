<?php
namespace StoreCore\FileSystem;

/**
 * File Integrity Monitor
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.0.1
 */
class FileIntegrityMonitor
{
    /**
     * @var string VERSION
     *   Semantic version (SemVer)
     */
    const VERSION = '0.0.1';


    /**
     * @var array|null $Files
     *   List of files being monitored.
     */
    private $Files;


    /**
     * Download integrity test file.
     *
     * A file integrity test cannot be saved in the file system it is supposed
     * to monitor.  The logical thing to do, is store the integrity test file
     * off-site, so it has to be downloaded.
     *
     * @param void
     * @return void
     */
    public function download()
    {
        if ($this->Files == null) {
            $this->getFiles();
        }

        $file = json_encode($this->Files);
        header('Cache-Control: private');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=file-integrity-test.json');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        echo $file;
        exit;
    }

    /**
     * Load an integrity check list of all files in a directory.
     *
     * @param string|null directory
     *   Optional path of a directory to parse.  If no directory is provided,
     *   StoreCore will parse the parent directory of the /FileSystem/
     *   directory and thus include the entire StoreCore library.
     */
    public function getFiles($directory = null)
    {
        if ($directory == null) {
            $directory = realpath(__DIR__ . '/../');
        }

        $files = scandir($directory);
        $files = array_diff($files, array('.', '..'));
        foreach ($files as $filename) {
            $path = $directory . DIRECTORY_SEPARATOR . $filename;
            if (is_dir($path)) {
                $this->getFiles($path);
            } else {
                $this->Files[$path] = array(
                    'md5_file'  => md5_file($path),
                    'sha1_file' => sha1_file($path),
                    'filectime' => filectime($path),
                    'filemtime' => filemtime($path),
                    'filesize'  => filesize($path),
                );
            }
        }
    }
}
