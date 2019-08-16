<?php
namespace Psr\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

interface UploadedFileFactoryInterface
{
    /**
     * Create a new uploaded file.
     *
     * If a size is not provided it will be determined by checking the size of
     * the stream.
     *
     * @link http://php.net/manual/features.file-upload.post-method.php
     * @link http://php.net/manual/features.file-upload.errors.php
     *
     * @param StreamInterface $stream
     *   The underlying stream representing the uploaded file content.
     *
     * @param int $size
     *   The size of the file in bytes.
     *
     * @param int $error
     *   The PHP file upload error.
     *
     * @param string $clientFilename
     *   The filename as provided by the client, if any.
     *
     * @param string $clientMediaType
     *   The media type as provided by the client, if any.
     *
     * @returns \Psr\Http\Message\UploadedFileInterface
     *
     * @throws \InvalidArgumentException If the file resource is not readable.
     */
    public function createUploadedFile($stream, $size = null, $error = \UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null);
}
