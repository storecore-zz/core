<?php
class TranslationMemoryCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testFileSystemBackupClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/TranslationMemoryCache.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\TranslationMemoryCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\TranslationMemoryCache');
        $this->assertNotEmpty($class->getConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\TranslationMemoryCache');
        $this->assertTrue(is_string($class->getConstant('VERSION')));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\TranslationMemoryCache::VERSION);
    }

    /**
     * @testdox Public static rebuild() method exists
     */
    public function testPublicStaticRebuildMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\TranslationMemoryCache');
        $this->assertTrue($class->hasMethod('rebuild'));
    }

    /**
     * @depends testPublicStaticRebuildMethodExists
     * @testdox Public static rebuild() method is public
     */
    public function testPublicStaticRebuildMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\TranslationMemoryCache', 'rebuild');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicStaticRebuildMethodExists
     * @testdox Public static rebuild() method is static
     */
    public function testPublicStaticRebuildMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\TranslationMemoryCache', 'rebuild');
        $this->assertTrue($method->isStatic());
    }
}
