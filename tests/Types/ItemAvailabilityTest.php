<?php
class ItemAvailabilityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testItemAvailabilityClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'ItemAvailability.php');
    }

    /**
     * @group hmvc
     * @testdox ItemAvailability is a VARCHAR
     */
    public function testItemAvailabilityIsAVarchar()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $this->assertInstanceOf(\StoreCore\Types\Varchar::class, $item_availability);
    }

    /**
     * @group hmvc
     * @testdox ItemAvailability implements TypeInterface
     */
    public function testItemAvailabilityImplementsTypeInterface()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $this->assertInstanceOf(\StoreCore\Types\TypeInterface::class, $item_availability);
    }

    /**
     * @group hmvc
     * @testdox ItemAvailability implements StringableInterface
     */
    public function testItemAvailabilityImplementsStringableInterface()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $item_availability);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\ItemAvailability');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\ItemAvailability::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\ItemAvailability::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\ItemAvailability::VERSION);
    }

    /**
     * @depends testItemAvailabilityImplementsStringableInterface
     * @testdox ItemAvailability is https://schema.org/InStock by default
     */
    public function testItemAvailabilityIsHttpsSchemaOrgInStockByDefault()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $string = (string)$item_availability;
        $this->assertSame('https://schema.org/InStock', $string);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox ItemAvailability does not accept integers in strict mode
     */
    public function testItemAvailabilityDoesNotAcceptIntegersInStrictMode()
    {
        $failure = new \StoreCore\Types\ItemAvailability(2, true);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox ItemAvailability does not accept numeric strings in strict mode
     */
    public function testItemAvailabilityDoesNotAcceptNumericStringsInStrictMode()
    {
        $failure = new \StoreCore\Types\ItemAvailability('2', true);
    }

    /**
     * @depends testItemAvailabilityImplementsStringableInterface
     * @testdox ItemAvailability accepts numeric strings if not in strict mode
     */
    public function testItemAvailabilityAcceptsNumericStringsIfNotInStrictMode()
    {
        $keys_and_values = array(
            1 => 'https://schema.org/Discontinued',
            2 => 'https://schema.org/InStock',
            3 => 'https://schema.org/InStoreOnly',
            4 => 'https://schema.org/LimitedAvailability',
            5 => 'https://schema.org/OnlineOnly',
            6 => 'https://schema.org/OutOfStock',
            7 => 'https://schema.org/PreOrder',
            8 => 'https://schema.org/PreSale',
            9 => 'https://schema.org/SoldOut',
        );

        foreach ($keys_and_values as $key => $value) {
            $item_availability = new \StoreCore\Types\ItemAvailability($key, false);
            $this->assertEquals($value, (string)$item_availability);
        }
    }
}
