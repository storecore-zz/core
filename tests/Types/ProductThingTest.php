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
     * @testdox Class extends Thing
     */
    public function testClassExtendsThing()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertInstanceOf(\StoreCore\Types\Thing::class, $thing);
    }

    /**
     * @group hmvc
     * @testdox Class implements StringableInterface
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Types\Product();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Product');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\Product::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\Product::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
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
     * @testdox Product::__toString() returns string
     */
    public function testProductToStringReturnsString()
    {
        $product = new \StoreCore\Types\Product();
        $product = (string) $product;
        $this->assertInternalType('string', $product);
    }

    /**
     * @group hmvc
     * @testdox Product::__toString() returns non-empty string
     */
    public function testProductToStringReturnsNonEmptyString()
    {
        $product = new \StoreCore\Types\Product();
        $product = (string) $product;
        $this->assertNotEmpty($product);
        $this->assertInternalType('string', $product);
    }
}
