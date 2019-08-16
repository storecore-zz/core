<?php
class ResponseFactoryInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ResponseFactoryInterface interface file exists
     */
    public function testResponseFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ResponseFactoryInterface.php');
    }
}
