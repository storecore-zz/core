<?php
class ServerRequestInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ServerRequestInterface interface file exists
     */
    public function testServerRequestInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ServerRequestInterface.php');
    }
}
