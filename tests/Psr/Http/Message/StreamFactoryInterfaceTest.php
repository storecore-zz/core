<?php
class StreamFactoryInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox StreamFactoryInterface interface file exists
     */
    public function testStreamFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'StreamFactoryInterface.php');
    }
}
