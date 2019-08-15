<?php
class RequestInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox RequestInterface interface file exists
     */
    public function testRequestInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'RequestInterface.php');
    }
}
