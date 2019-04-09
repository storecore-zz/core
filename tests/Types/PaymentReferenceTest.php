<?php
class PaymentReferenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testPaymentReferenceClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'PaymentReference.php');
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Types\PaymentReference();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\PaymentReference');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $class = new \ReflectionClass('\StoreCore\Types\PaymentReference');
        $this->assertNotEmpty($class->getConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $class = new \ReflectionClass('\StoreCore\Types\PaymentReference');
        $this->assertTrue(is_string($class->getConstant('VERSION')));
    }
}
