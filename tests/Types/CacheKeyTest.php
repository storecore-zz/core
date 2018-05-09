<?php
class CacheKeyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Core cache key class file exists
     */
    public function testCoreStoreIdClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'CacheKey.php');
    }

    /**
     * @group distro
     * @testdox Implemented Stringable interface file exists
     */
    public function testImplementedStringableInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'StringableInterface.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CacheKey');
        $this->assertTrue($class->hasConstant('VERSION'));
    }
}
