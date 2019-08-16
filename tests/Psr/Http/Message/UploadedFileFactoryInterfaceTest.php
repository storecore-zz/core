<?php
class UploadedFileFactoryInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox UploadedFileFactoryInterface interface file exists
     */
    public function testUploadedFileFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UploadedFileFactoryInterface.php');
    }
}
