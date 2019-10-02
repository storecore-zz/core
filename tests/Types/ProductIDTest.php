<?php
class ProductIDTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ProductID class file exists
     */
    public function testProductIDClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'ProductID.php');
    }

    /**
     * @group distro
     * @testdox Extended MediumintUnsigned class file exists
     */
    public function testExtendedMediumintUnsignedClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'MediumintUnsigned.php');
    }

    /**
     * @group hmvc
     * @testdox Product ID is a MEDIUMINT UNSIGNED
     */
    public function testProductIdIsAMediumintUnsigned()
    {
        $product_id = new \StoreCore\Types\ProductID(12345);
        $this->assertInstanceOf(\StoreCore\Types\MediumintUnsigned::class, $product_id);
    }

    /**
     * @group hmvc
     * @testdox Product ID implements TypeInterface
     */
    public function testProductIdImplementsTypeInterface()
    {
        $product_id = new \StoreCore\Types\ProductID(12345);
        $this->assertInstanceOf(\StoreCore\Types\TypeInterface::class, $product_id);
    }

    /**
     * @group hmvc
     * @testdox Product ID implements StringableInterface
     */
    public function testProductIdImplementsStringableInterface()
    {
        $product_id = new \StoreCore\Types\ProductID(12345);
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $product_id);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\ProductID');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\ProductID::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\ProductID::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\ProductID::VERSION);
    }


    /**
     * @testdox Constructor requires at least one paramater
     */
    public function testConstructorRequiresAtLeastOneParameter()
    {
        $method = new \ReflectionMethod(\StoreCore\Types\ProductID::class, '__construct');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Constructor throws invalid argument exception on string
     */
    public function testConstructorThrowsInvalidArgumentExceptionOnString()
    {
        $failure = new \StoreCore\Types\ProductID('FooBar');
    }

    /**
     * @expectedException \DomainException
     * @testdox Constructor throws domain exception on 0 (zero)
     */
    public function testConstructorThrowsDomainExceptionOnZero()
    {
        $failure = new \StoreCore\Types\ProductID(0);
    }
}
