<?php
class ClientExceptionInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ClientExceptionInterface interface file exists
     */
    public function testClientExceptionInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Client' . DIRECTORY_SEPARATOR .  'ClientExceptionInterface.php');
    }
}
