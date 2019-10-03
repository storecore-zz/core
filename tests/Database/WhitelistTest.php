<?php
/**
 * @coversDefaultClass \StoreCore\Database\Whitelist
 * @group security
 */
class WhitelistTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Whitelist class file exists
     */
    public function testWhitelistClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Whitelist.php');
    }

    /**
     * @group hmvc
     * @testdox Whitelist is a database model
     */
    public function testWhitelistIsADatabaseModel()
    {
        $class = new \ReflectionClass(\StoreCore\Database\Whitelist::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\Database\AbstractModel::class));
    }

    /**
     * @group hmvc
     * @testdox Whitelist is countable
     */
    public function testWhitelistIsCountable()
    {
        $class = new \ReflectionClass(\StoreCore\Database\Whitelist::class);
        $this->assertTrue($class->isSubclassOf(\Countable::class));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Whitelist');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Whitelist::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Whitelist::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Whitelist::VERSION);
    }


    /**
     * @testdox Whitelist::count() exists
     */
    public function testWhitelistCountExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Whitelist');
        $this->assertTrue($class->hasMethod('count'));
    }

    /**
     * @depends testWhitelistCountExists
     * @testdox Whitelist::count() is public
     */
    public function testWhitelistCountIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Whitelist', 'count');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Whitelist::count() has no parameters
     */
    public function testWhitelistCountHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Whitelist', 'count');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
