<?php
namespace StoreCore;

/**
 * Asset Management
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version   0.1.0
 */
class Asset
{
    const VERSION = '0.1.0';

    /**
     * @type string $FileName
     * @type string $FileType
     */
    private $FileName;
    private $FileType;

    /**
     * @type array $Types
     *   Array matching lowercase file extensions to MIME types.
     */
    private $Types = array(
        'css'   => 'text/css; charset=utf-8',
        'eot'   => 'application/vnd.ms-fontobject',
        'gif'   => 'image/gif',
        'ico'   => 'image/x-icon',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'js'    => 'text/javascript; charset=utf-8',
        'otf'   => 'application/font-sfnt',
        'png'   => 'image/png',
        'svg'   => 'image/svg+xml',
        'ttc'   => 'application/font-sfnt',
        'ttf'   => 'application/font-sfnt',
        'woff'  => 'application/font-woff',
        'woff2' => 'font/woff2',
    );

    /**
     * Silently publish a cacheable asset file.
     *
     * @param string $filename
     * @param null|string $filetype
     * @return void
     */
    public function __construct($filename, $filetype = null)
    {
        $this->setFileName($filename);

        if ($filetype === null) {
            $this->setFileType(pathinfo($filename, PATHINFO_EXTENSION));
        } else {
            $this->setFileType($filetype);
        }

        if ($this->fileExists()) {
            $this->getFile();
        }
    }

    /**
     * Check if an asset file exists.
     *
     * @param void
     * @return bool
     */
    private function fileExists()
    {
        // File type is not supported
        if ($this->FileType === null) {
            return false;
        }

        return is_file(\StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . $this->FileType . DIRECTORY_SEPARATOR . $this->FileName);
    }

    /**
     * Publish the asset file.
     *
     * @param void
     * @return void
     */
    private function getFile()
    {
        if ($this->FileType == 'css' || $this->FileType == 'js' || $this->FileType == 'svg') {
            ob_start('ob_gzhandler');
        }

        // Cache for 365 days = 31536000 seconds
        header('Cache-Control: public, max-age=31536000', true);
        header('Pragma: cache', true);
        header('Content-Type: ' . $this->Types[$this->FileType], true);
        header('X-Powered-By: StoreCore/' . \StoreCore\VERSION, true);

        $file = \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . $this->FileType . DIRECTORY_SEPARATOR . $this->FileName;

        $last_modified = filemtime($file);
        $etag = md5_file($file);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_modified) . ' GMT');
        header('Etag: ' . $etag);

        $http_if_none_match = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            if (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified || $http_if_none_match == $etag) {
                header('HTTP/1.1 304 Not Modified', true, 304);
                exit;
            }
        }

        readfile($file);
        exit;
    }

    /**
     * Set the asset filename.
     *
     * @param string $filename
     * @return void
     */
    private function setFileName($filename)
    {
        $filename = mb_strtolower($filename, 'UTF-8');
        $this->FileName = $filename;
    }

    /**
     * Set the asset filetype.
     *
     * @param string $filetype
     * @return void
     */
    private function setFileType($filetype)
    {
        if (array_key_exists($filetype, $this->Types)) {
            $this->FileType = $filetype;
        }
    }
}
