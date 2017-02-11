<?php
/**
 * @group hmvc
 */
class AssetCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreAssetCacheClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AssetCache.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AssetCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox AssetCache::find() method exists
     */
    public function testAssetCacheFindMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AssetCache');
        $this->assertTrue($class->hasMethod('find'));
    }

    /**
     * @testdox AssetCache::find() method is public
     */
    public function testAssetCacheFindMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AssetCache', 'find');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox AssetCache::find() method is static
     */
    public function testAssetCacheFindMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\AssetCache', 'find');
        $this->assertTrue($method->isStatic());
    }
}
