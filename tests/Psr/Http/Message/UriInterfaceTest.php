<?php
class UriInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox UriInterface interface file exists
     */
    public function testUriInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UriInterface.php');
    }
}
