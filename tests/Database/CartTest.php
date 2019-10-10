<?php
/**
 * @coversDefaultClass \StoreCore\Database\Cart
 */
class CartTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Cart class file exists
     */
    public function testCartClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Cart.php');
    }

    /**
     * @group hmvc
     * @testdox Cart class is concrete
     */
    public function testCartClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox Cart is a database model
     */
    public function testCartIsADatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }

    /**
     * @group hmvc
     * @testdox Cart is an order database model
     */
    public function testCartIsAnOrderDatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\Order'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Cart::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Cart::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Cart::VERSION);
    }


    /**
     * @testdox Cart::getCartID() exists
     */
    public function testCartGetCartIDExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertTrue($class->hasMethod('getCartID'));
    }

    /**
     * @depends testCartGetCartIDExists
     * @testdox Cart::getCartID() is public
     */
    public function testCartGetCartIDIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Cart', 'getCartID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCartGetCartIDExists
     * @testdox Cart::getCartID() has no parameters
     */
    public function testCartGetCartIDHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Cart', 'getCartID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Cart::setCartID() exists
     */
    public function testCartSetCartIDExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Cart');
        $this->assertTrue($class->hasMethod('setCartID'));
    }

    /**
     * @depends testCartSetCartIDExists
     * @testdox Cart::setCartID() is public
     */
    public function testCartSetCartIDIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Cart', 'setCartID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCartSetCartIDExists
     * @testdox Cart::setCartID() has one required parameter
     */
    public function testCartSetCartIDHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Cart', 'setCartID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
