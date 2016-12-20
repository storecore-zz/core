<?php
namespace StoreCore\FileSystem;

/**
 * Clean up a production environment.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class CleanUp
{
    /**
     * @param void
     * @return void
     */
    public static function execute()
    {
        $dir = realpath(__DIR__ . '/../../');

        if (is_dir($dir)) {
            $dir = $dir . DIRECTORY_SEPARATOR;

            $files = array(
                $dir . '.editorconfig',
                $dir . 'CONTRIBUTING.md',
                $dir . 'LICENSE.html',
                $dir . 'LICENSE.txt',
                $dir . 'README.md',
            );
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            self::removeDirectory($dir . 'install');
            self::removeDirectory($dir . 'tests');
        }
    }

    /**
     * Remove an entire directory.
     *
     * @param string $directory
     * @return void
     */
    private static function removeDirectory($directory)
    {
        if (is_dir($directory)) {
            $objects = scandir($directory);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    $object = $directory . DIRECTORY_SEPARATOR . $object;
                    if (filetype($object) == 'dir') {
                        self::removeDirectory($object);
                    } else {
                        unlink($object);
                    }
                }
            }
            reset($objects);
            rmdir($directory);
        }
    }
}
