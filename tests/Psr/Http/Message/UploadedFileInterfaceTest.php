<?php
class UploadedFileInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox UploadedFileInterface interface file exists
     */
    public function testUploadedFileInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UploadedFileInterface.php');
    }
}
