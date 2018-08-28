<?php
class CartIDTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Core cart ID class file exists
     */
    public function testCoreCartIdClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'CartID.php');
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
     * @testdox Class implements \StoreCore\Types\StringableInterface
     */
    public function testClassImplementsStoreCoreTypesStringableInterface()
    {
        $cart_id = new \StoreCore\Types\CartID();
        $this->assertTrue($cart_id instanceof \StoreCore\Types\StringableInterface);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CartID');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     */
    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\CartID::VERSION);
    }

    /**
     * @testdox Public decode() method exists
     */
    public function testPublicDecodeMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CartID');
        $this->assertTrue($class->hasMethod('decode'));
    }

    /**
     * @testdox Public encode() method exists
     */
    public function testPublicEncodeMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CartID');
        $this->assertTrue($class->hasMethod('encode'));
    }

    /**
     * @testdox Public encode() method returns non-empty string
     */
    function testPublicEncodeMethodReturnsNonEmptyString()
    {
        $cart_id = new \StoreCore\Types\CartID();
        $this->assertTrue(is_string($cart_id->encode()));
        $this->assertFalse(empty($cart_id->encode()));
    }

    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\CartID');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\CartID', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns non-empty string
     */
    function testPublicToStringMethodReturnsNonEmptyString()
    {
        $cart_id = new \StoreCore\Types\CartID();
        $this->assertTrue(is_string((string)$cart_id));
        $cart_id = new \StoreCore\Types\CartID();
        $this->assertFalse(empty((string)$cart_id));
    }
}
