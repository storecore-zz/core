<?php
class RequestHandlerInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox RequestHandlerInterface interface file exists
     */
    public function testRequestHandlerInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Server' . DIRECTORY_SEPARATOR .  'RequestHandlerInterface.php');
    }
}
