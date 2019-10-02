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
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\TranslationMemoryCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\TranslationMemoryCache::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\TranslationMemoryCache::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
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
