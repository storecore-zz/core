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


    /**
     * @group hmvc
     * @testdox Order::getOrderID() exists
     */
    public function testOrderGetOrderIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('getOrderID'));
    }

    /**
     * @group hmvc
     * @depends testOrderGetOrderIdExists
     * @testdox Order::getOrderID() is public
     */
    public function testOrderGetOrderIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'getOrderID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group hmvc
     * @depends testOrderGetOrderIdExists
     * @testdox Order::getOrderID() has no parameters
     */
    public function testOrderGetOrderIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'getOrderID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @group hmvc
     * @testdox Order::getStoreID() exists
     */
    public function testOrderGetStoreIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('getStoreID'));
    }

    /**
     * @group hmvc
     * @depends testOrderGetStoreIdExists
     * @testdox Order::getStoreID() is public
     */
    public function testOrderGetStoreIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'getStoreID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group hmvc
     * @depends testOrderGetStoreIdExists
     * @testdox Order::getStoreID() has no parameters
     */
    public function testOrderGetStoreIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'getStoreID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Order::isWishList() exists
     */
    public function testOrderIsWishListExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('isWishList'));
    }

    /**
     * @depends testOrderIsWishListExists
     * @testdox Order::isWishList() is public
     */
    public function testOrderIsWishListIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'isWishList');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderIsWishListExists
     * @testdox Order::isWishList() has no parameters
     */
    public function testOrderIsWishListHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'isWishList');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @group hmvc
     * @testdox Order::setOrderID() exists
     */
    public function testOrderSetOrderIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('setOrderID'));
    }

    /**
     * @group hmvc
     * @depends testOrderSetOrderIdExists
     * @testdox Order::setOrderID() is public
     */
    public function testOrderSetOrderIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setOrderID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group hmvc
     * @depends testOrderSetOrderIdExists
     * @testdox Order::setOrderID() has one required parameter
     */
    public function testOrderSetOrderIdHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setOrderID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Order::setStoreID() exists
     */
    public function testOrderSetStoreIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('setStoreID'));
    }

    /**
     * @depends testOrderSetStoreIdExists
     * @testdox Order::setStoreID() is public
     */
    public function testOrderSetStoreIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setStoreID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderSetStoreIdExists
     * @testdox Order::setStoreID() has one required parameter
     */
    public function testOrderSetStoreIdHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setStoreID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @group hmvc
     * @testdox Order::setWishList() exists
     */
    public function testOrderSetWishListExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Order');
        $this->assertTrue($class->hasMethod('setWishList'));
    }

    /**
     * @group hmvc
     * @depends testOrderSetWishListExists
     * @testdox Order::setWishList() is public
     */
    public function testOrderSetWishListIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setWishList');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group hmvc
     * @depends testOrderSetWishListExists
     * @testdox Order::setWishList() has one optional parameter
     */
    public function testOrderSetWishListHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Order', 'setWishList');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
