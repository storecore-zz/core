<?php
class FileSystemBlacklistTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testFileSystemBlacklistClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/Blacklist.php');
    }

    /**
     * @group hmvc
     */
    public function testFileSystemBlacklistIsAController()
    {
        $blacklist = new \StoreCore\FileSystem\Blacklist(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\StoreCore\AbstractController::class, $blacklist);
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Blacklist');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\FileSystem\Blacklist::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\Blacklist::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\Blacklist::VERSION);
    }


    /**
     * @testdox Public static exists() method exists
     */
    public function testPublicStaticExistsMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Blacklist');
        $this->assertTrue($class->hasMethod('exists'));
    }

    /**
     * @testdox Public static exists() method is public
     */
    public function testPublicStaticExistsMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'exists');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public static exists() method is static
     */
    public function testPublicStaticExistsMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'exists');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox Public static exists() method has one required parameter
     */
    public function testPublicStaticExistsMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'exists');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Public flush() method exists
     */
    public function testPublicFlushMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Blacklist');
        $this->assertTrue($class->hasMethod('flush'));
    }

    /**
     * @testdox Public flush() method is public
     */
    public function testPublicFlushMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'flush');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public flush() method has no parameters
     */
    public function testPublicFlushMethodHasNoParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'flush');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
