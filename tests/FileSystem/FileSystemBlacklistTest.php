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
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\Blacklist::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\Blacklist::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\Blacklist::VERSION);
    }


    /**
     * @testdox Blacklist::has() exists
     */
    public function testBlacklistHasExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Blacklist');
        $this->assertTrue($class->hasMethod('has'));
    }

    /**
     * @depends testBlacklistHasExists
     * @testdox Blacklist::has() is public
     */
    public function testBlacklistHasIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'has');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testBlacklistHasExists
     * @testdox Blacklist::has() is static
     */
    public function testBlacklistHasIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'has');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @depends testBlacklistHasExists
     * @testdox Blacklist::has() has one required parameter
     */
    public function testBlacklistHasHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'has');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testBlacklistHasIsStatic
     * @depends testBlacklistHasHasOneRequiredParameter
     * @testdox Blacklist::has() returns boolean
     */
    public function testBlacklistHasReturnsBoolean()
    {
        $this->assertInternalType('bool', \StoreCore\FileSystem\Blacklist::has('93.184.216.34'));
        $this->assertInternalType('bool', \StoreCore\FileSystem\Blacklist::has('2606:2800:220:1:248:1893:25c8:1946'));
    }

    /**
     * @depends testBlacklistHasIsStatic
     * @depends testBlacklistHasHasOneRequiredParameter
     * @testdox Blacklist::has() returns false on empty string
     */
    public function testBlacklistHasReturnsFalseOnEmptyString()
    {
        $this->assertFalse(\StoreCore\FileSystem\Blacklist::has(''));
    }

    /**
     * @depends testBlacklistHasIsStatic
     * @depends testBlacklistHasHasOneRequiredParameter
     * @testdox Blacklist::has() returns false on invalid arguments
     */
    public function testBlacklistHasReturnsFalseOnInvalidArguments()
    {
        $this->assertFalse(\StoreCore\FileSystem\Blacklist::has((bool) true));
        $this->assertFalse(\StoreCore\FileSystem\Blacklist::has((int) 42));
        $this->assertFalse(\StoreCore\FileSystem\Blacklist::has('This is not an IP address but a string.'));
    }


    /**
     * @testdox Blacklist::flush() exists
     */
    public function testBlacklistFlushExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Blacklist');
        $this->assertTrue($class->hasMethod('flush'));
    }

    /**
     * @testdox Blacklist::flush() is public
     */
    public function testBlacklistFlushIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'flush');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Blacklist::flush() has no parameters
     */
    public function testBlacklistFlushHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Blacklist', 'flush');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
