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
        $this->assertTrue($item_availability instanceof \StoreCore\Types\Varchar);
    }

    /**
     * @group hmvc
     * @testdox ItemAvailability implements TypeInterface
     */
    public function testItemAvailabilityImplementsTypeInterface()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $this->assertTrue($item_availability instanceof \StoreCore\Types\TypeInterface);
    }

    /**
     * @group hmvc
     * @testdox ItemAvailability implements StringableInterface
     */
    public function testItemAvailabilityImplementsStringableInterface()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $this->assertTrue($item_availability instanceof \StoreCore\Types\StringableInterface);
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
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Types\ItemAvailability::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Types\ItemAvailability::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\ItemAvailability::VERSION);
    }

    /**
     * @depends testItemAvailabilityImplementsStringableInterface
     * @testdox ItemAvailability is http://schema.org/InStock by default
     */
    public function testItemAvailabilityIsHttpSchemaOrgInStockByDefault()
    {
        $item_availability = new \StoreCore\Types\ItemAvailability();
        $string = (string)$item_availability;
        $this->assertSame('http://schema.org/InStock', $string);
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
            1 => 'http://schema.org/Discontinued',
            2 => 'http://schema.org/InStock',
            3 => 'http://schema.org/InStoreOnly',
            4 => 'http://schema.org/LimitedAvailability',
            5 => 'http://schema.org/OnlineOnly',
            6 => 'http://schema.org/OutOfStock',
            7 => 'http://schema.org/PreOrder',
            8 => 'http://schema.org/PreSale',
            9 => 'http://schema.org/SoldOut',
        );

        foreach ($keys_and_values as $key => $value) {
            $item_availability = new \StoreCore\Types\ItemAvailability($key, false);
            $this->assertEquals($value, (string)$item_availability);
        }
    }
}
