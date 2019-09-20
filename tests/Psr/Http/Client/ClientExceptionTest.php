<?php
class ClientExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ClientException class file exists
     */
    public function testClientExceptionClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Client' . DIRECTORY_SEPARATOR .  'ClientException.php');
    }

    /**
     * @expectedException \Psr\Http\Client\ClientException
     * @group hmvc
     * @testdox ClientException is an Exception
     */
    public function testClientExceptionIsAnException()
    {
        throw new \Psr\Http\Client\ClientException();
    }

    /**
     * @depends testClientExceptionIsAnException
     * @group hmvc
     * @testdox ClientException implements ClientExceptionInterface
     */
    public function testClientExceptionImplementsClientExceptionInterface()
    {
        try {
            throw new \Psr\Http\Client\ClientException();
        } catch (\Exception $e) {
            $this->assertInstanceOf(\Psr\Http\Client\ClientExceptionInterface::class, $e);
        }
    }
}
