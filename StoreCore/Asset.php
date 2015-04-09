<?php
namespace StoreCore;

/**
 * Asset Management
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   0.1.0
 */
class Asset
{
    /**
     * @type string $FileName
     * @type string $FileType
     */
    private $FileName;
    private $FileType;

    /**
     * @type array $Types
     *     Array matching lowercase file extensions to MIME types.
     */
    private $Types = array(
        'css'  => 'text/css; charset=utf-8',
        'gif'  => 'image/gif',
        'ico'  => 'image/x-icon',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'js'   => 'text/javascript; charset=utf-8',
        'png'  => 'image/png',
    );

    /**
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
     * @api
     * @param void
     * @return bool
     */
    public function fileExists()
    {
        // File type is not supported
        if ($this->FileType === null) {
            return false;
        }

        return is_file(STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'assets' . DIRECTORY_SEPARATOR . $this->FileType . DIRECTORY_SEPARATOR . $this->FileName);
    }

    /**
     * @param void
     * @return void
     */
    private function getFile()
    {
        if ($this->FileType == 'css' || $this->FileType == 'js') {
            ob_start('ob_gzhandler');
        }
        
        // Cache for 365 days = 31536000 seconds
        header('Cache-Control: public, max-age=31536000', true);
        header('Pragma: cache', true);
        header('Content-Type: ' . $this->Types[$this->FileType], true);
        header('X-Powered-By: StoreCore/' . STORECORE_VERSION, true);

        $file = STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'assets' . DIRECTORY_SEPARATOR . $this->FileType . DIRECTORY_SEPARATOR . $this->FileName;

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
     * @param string $filename
     * @return void
     */
    private function setFileName($filename)
    {
        $filename = mb_strtolower($filename, 'UTF-8');
        $this->FileName = $filename;
    }

    /**
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
