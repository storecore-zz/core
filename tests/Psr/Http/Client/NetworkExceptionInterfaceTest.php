<?php
class NetworkExceptionInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox NetworkExceptionInterface interface file exists
     */
    public function testNetworkExceptionInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Client' . DIRECTORY_SEPARATOR .  'NetworkExceptionInterface.php');
    }
}
