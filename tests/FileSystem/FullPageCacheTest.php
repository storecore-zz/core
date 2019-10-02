<?php
class FullPageCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testFileSystemFullPageCacheClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/FullPageCache.php');
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FullPageCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\FullPageCache::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\FullPageCache::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\FullPageCache::VERSION);
    }


    /**
     * @testdox Public static trigger() method exists
     */
    public function testPublicStaticTriggerMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FullPageCache');
        $this->assertTrue($class->hasMethod('trigger'));
    }

    /**
     * @depends testPublicStaticTriggerMethodExists
     * @testdox Public static trigger() method is public
     */
    public function testPublicStaticTriggerMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FullPageCache', 'trigger');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicStaticTriggerMethodExists
     * @testdox Public static trigger() method is static
     */
    public function testPublicStaticTriggerMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FullPageCache', 'trigger');
        $this->assertTrue($method->isStatic());
    }
}
