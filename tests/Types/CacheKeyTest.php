<?php
class CacheKeyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Cache key class file exists
     */
    public function testCacheKeyClassFileExists()
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
     * @group hmvc
     * @testdox Cache key implements Stringable interface
     */
    public function testCacheKeyImplementsStringableInterface()
    {
        $cache_key = new \StoreCore\Types\CacheKey();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $cache_key);
    }

    /**
     * @depends testCacheKeyImplementsStringableInterface
     * @group hmvc
     * @testdox Stringable object is a non-empty string
     */
    public function testStringableObjectIsANonEmptyString()
    {
        $cache_key = new \StoreCore\Types\CacheKey();
        $this->assertInternalType('string', (string)$cache_key);
        $this->assertNotEmpty((string)$cache_key);
    }


    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CacheKey');
        $this->assertInternalType('string', \StoreCore\Types\CacheKey::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\CacheKey::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\CacheKey::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\CacheKey::VERSION);
    }
}
