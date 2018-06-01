<?php
class ProductThingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testProductClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'Product.php');
    }

    /**
     * @group distro
     */
    public function testExtendedThingClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'Thing.php');
    }

    /**
     * @group hmvc
     */
    public function testClassExtendsThing()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertTrue($thing instanceof \StoreCore\Types\Thing);
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Types\Product();
        $this->assertTrue($object instanceof \StoreCore\Types\StringableInterface);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Product');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Product');
        $class_constant = $class->getConstant('VERSION');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\Product::VERSION);
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Product');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method returns string
     */
    public function testPublicToStringMethodReturnsString()
    {
        $product = new \StoreCore\Types\Product();
        $product = (string)$product;
        $this->assertTrue(is_string($product));
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method returns non-empty string
     */
    public function testPublicToStringMethodReturnsNonEmptyString()
    {
        $product = new \StoreCore\Types\Product();
        $product = (string)$product;
        $this->assertFalse(empty($product));
    }
}
