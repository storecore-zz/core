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
     * @group hmvc
     * @testdox ClientException is an Exception
     */
    public function testClientExceptionIsAnException()
    {
        $stub = $this->getMock(\Psr\Http\Client\ClientException::class);
        $this->assertInstanceOf(\Exception::class, $stub);
    }

    /**
     * @group hmvc
     * @testdox ClientException implements ClientExceptionInterface
     */
    public function testClientExceptionImplementsClientExceptionInterface()
    {
        $stub = $this->getMock(\Psr\Http\Client\ClientException::class);
        $this->assertInstanceOf(\Psr\Http\Client\ClientExceptionInterface::class, $stub);
    }
}
