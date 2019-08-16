<?php
class ResponseInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ResponseInterface interface file exists
     */
    public function testResponseInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ResponseInterface.php');
    }
}
