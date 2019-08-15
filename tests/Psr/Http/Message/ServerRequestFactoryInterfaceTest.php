<?php
class ServerRequestFactoryInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ServerRequestFactoryInterface interface file exists
     */
    public function testServerRequestFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ServerRequestFactoryInterface.php');
    }
}
