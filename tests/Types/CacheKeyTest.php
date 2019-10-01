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
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CacheKey');
        $this->assertInternalType('string', \StoreCore\Types\CacheKey::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\CacheKey::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\CacheKey::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\CacheKey::VERSION);
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
     * @depends testStringableObjectIsANonEmptyString
     * @testdox Cache key is case-insensitive
     */
    public function testCacheKeyIsCaseInsensitive()
    {
        $foobar = new \StoreCore\Types\CacheKey('foo/bar');
        $FooBar = new \StoreCore\Types\CacheKey('Foo/Bar');
        $this->assertSame((string) $FooBar, (string) $foobar);
    }

    /**
     * @depends testStringableObjectIsANonEmptyString
     * @testdox Cache key ignores HTTP URI scheme
     */
    public function testCacheKeyIgnoresHttpUriScheme()
    {
        $http  = new \StoreCore\Types\CacheKey('http://www.example.com/foo-bar/baz-qux');
        $https = new \StoreCore\Types\CacheKey('https://www.example.com/foo-bar/baz-qux');
        $this->assertSame((string) $https, (string) $http);
    }
}
