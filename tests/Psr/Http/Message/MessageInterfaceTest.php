<?php
class MessageInterfaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox MessageInterface interface file exists
     */
    public function testMessageInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'MessageInterface.php');
    }
}
