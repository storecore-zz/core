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
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FullPageCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FullPageCache');
        $this->assertNotEmpty($class->getConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FullPageCache');
        $this->assertTrue(is_string($class->getConstant('VERSION')));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
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
