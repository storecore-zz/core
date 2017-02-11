<?php
/**
 * @group hmvc
 */
class FullPageCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreFullPageCacheClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FullPageCache.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FullPageCache');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testFindMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FullPageCache', 'find');
        $this->assertTrue($method->isPublic());
    }

    public function testFindMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FullPageCache', 'find');
        $this->assertTrue($method->isStatic());
    }
}
