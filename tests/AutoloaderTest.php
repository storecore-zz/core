<?php
class MockAutoloader extends \StoreCore\Autoloader
{
    protected $files = array();

    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    protected function requireFile($file)
    {
        return in_array($file, $this->files);
    }
}

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreAutoloaderClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Autoloader.php');
    }

    /**
     * @group distro
     */
    public function testCoreBootloaderFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'bootloader.php');
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Autoloader');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Autoloader::VERSION);
        $this->assertInternalType('string', \StoreCore\Autoloader::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0-beta.1', \StoreCore\Autoloader::VERSION);
    }


    /**
     * @testdox Autoloader::addNamespace() exists
     */
    public function testAutoloaderAddNamespaceExists()
    {
        $class = new \ReflectionClass('\StoreCore\Autoloader');
        $this->assertTrue($class->hasMethod('addNamespace'));
    }

    /**
     * @depends testAutoloaderAddNamespaceExists
     * @testdox Autoloader::addNamespace() is public
     */
    public function tesAutoloaderAddNamespaceIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Autoloader', 'addNamespace');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testAutoloaderAddNamespaceExists
     * @testdox Autoloader::addNamespace() has three parameters
     */
    public function testAutoloaderAddNamespaceThreeParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Autoloader', 'addNamespace');
        $this->assertTrue($method->getNumberOfParameters() === 3);
    }

    /**
     * @depends testAutoloaderAddNamespaceThreeParameters
     * @testdox Autoloader::addNamespace() has two required parameters
     */
    public function testAutoloaderAddNamespaceTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Autoloader', 'addNamespace');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }


    /**
     * @testdox Autoloader::register() exists
     */
    public function testAutoloaderRegisterExists()
    {
        $class = new \ReflectionClass('\StoreCore\Autoloader');
        $this->assertTrue($class->hasMethod('register'));
    }

    /**
     * @depends testAutoloaderRegisterExists
     * @testdox Autoloader::register() is public
     */
    public function tesAutoloaderRegisterIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Autoloader', 'register');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testAutoloaderRegisterExists
     * @testdox Autoloader::register() has no parameters
     */
    public function testAutoloaderAddNamespaceNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Autoloader', 'register');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
