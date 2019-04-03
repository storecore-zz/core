<?php
class WishListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox WishList class file exists
     */
    public function testWishListClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR .  'WishList.php');
    }

    /**
     * @group hmvc
     * @testdox Extended Order class file exists
     */
    public function testExtendedOrderClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR .  'Order.php');
    }

    /**
     * @group hmvc
     * @testdox WishList is an Order
     */
    public function testWishListIsAnOrder()
    {
        $class = new \ReflectionClass('\StoreCore\Database\WishList');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\Order'));
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\WishList');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Database\WishList::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Database\WishList::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\WishList::VERSION);
    }
}