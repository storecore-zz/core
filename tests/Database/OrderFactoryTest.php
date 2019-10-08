<?php
/**
 * @coversDefaultClass \StoreCore\Database\OrderFactory
 */
class OrderFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox OrderFactory class file exists
     */
    public function testOrderFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/OrderFactory.php');
    }

    /**
     * @group hmvc
     * @testdox OrderFactory class is concrete
     */
    public function testOrderFactoryClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderFactory');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox OrderFactory is a database model
     */
    public function testOrderFactoryIsADatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderFactory');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderFactory');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\OrderFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\OrderFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\OrderFactory::VERSION);
    }


    /**
     * @testdox OrderFactory::createOrder() exists
     */
    public function testOrderFactoryCreateOrderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderFactory');
        $this->assertTrue($class->hasMethod('createOrder'));
    }

    /**
     * @depends testOrderFactoryCreateOrderExists
     * @testdox OrderFactory::createOrder() is public
     */
    public function testOrderFactoryCreateOrderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderFactory', 'createOrder');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderFactoryCreateOrderExists
     * @testdox OrderFactory::createOrder() has one optional parameter
     */
    public function testOrderFactoryCreateOrderHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderFactory', 'createOrder');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox OrderFactory::createWishList() exists
     */
    public function testOrderFactoryCreateWishListExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderFactory');
        $this->assertTrue($class->hasMethod('createWishList'));
    }

    /**
     * @depends testOrderFactoryCreateWishListExists
     * @testdox OrderFactory::createWishList() is public
     */
    public function testOrderFactoryCreateWishListIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderFactory', 'createWishList');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderFactoryCreateWishListExists
     * @testdox OrderFactory::createWishList() has one optional parameter
     */
    public function testOrderFactoryCreateWishListHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderFactory', 'createWishList');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
