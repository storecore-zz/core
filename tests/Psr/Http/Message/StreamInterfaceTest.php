<?php
class StreamInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox StreamInterface interface file exists
     */
    public function testStreamInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'StreamInterface.php');
    }
}
