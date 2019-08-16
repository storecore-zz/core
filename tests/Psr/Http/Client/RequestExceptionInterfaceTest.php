<?php
class RequestExceptionInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox RequestExceptionInterface interface file exists
     */
    public function testRequestExceptionInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Client' . DIRECTORY_SEPARATOR .  'RequestExceptionInterface.php');
    }
}
