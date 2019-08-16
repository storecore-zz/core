<?php
class MiddlewareInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox MiddlewareInterface interface file exists
     */
    public function testMiddlewareInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Server' . DIRECTORY_SEPARATOR .  'MiddlewareInterface.php');
    }
}
