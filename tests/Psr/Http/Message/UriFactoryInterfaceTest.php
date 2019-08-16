<?php
class UriFactoryInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox UriFactoryInterface interface file exists
     */
    public function testUriFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UriFactoryInterface.php');
    }
}
