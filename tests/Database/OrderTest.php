<?php
/**
 * @coversDefaultClass \StoreCore\Database\Order
 */
class OrderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Order class file exists
     */
    public function testOrderClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Order.php');
    }

    /**
     * @group hmvc
     * @testdox Order class is concrete
     */
    public function testOrderClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox Order is a database model
     */
    public function testOrderIsADatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }

    /**
     * @testdox Order is countable
     */
    public function testOrderIsCountable()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->isSubclassOf('\Countable'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Order::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Order::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Order::VERSION);
    }


    /**
     * @testdox Order::count() exists
     */
    public function testOrderCountExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('count'));
    }

    /**
     * @depends testOrderCountExists
     * @testdox Order::count() is public
     */
    public function testOrderCountIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'count');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderCountExists
     * @testdox Order::count() has no parameters
     */
    public function testOrderCountHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'count');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
