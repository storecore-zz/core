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

    /**
     * @depends testVersionConstantIsNotEmpty
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\Types\PaymentReference::VERSION);
    }


    /**
     * @testdox PaymentReference::__construct() exists
     */
    public function testPaymentReferenceConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\PaymentReference');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testPaymentReferenceConstructExists
     * @testdox PaymentReference::__construct() is public
     */
    public function testPaymentReferenceConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\PaymentReference', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPaymentReferenceConstructExists
     * @testdox PaymentReference::__construct() has one optional parameter
     */
    public function testPaymentReferenceConstructHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\PaymentReference', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox PaymentReference::__toString() exists
     */
    public function testPaymentReferenceToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\PaymentReference');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox PaymentReference::__toString() returns non-empty string
     */
    public function testPaymentReferenceToStringReturnsNonEmptyString()
    {
        $data_object = new \StoreCore\Types\PaymentReference();
        $data = (string)$data_object;
        $this->assertNotEmpty($data);
        $this->assertInternalType('string', $data);
    }

    /**
     * @depends testPaymentReferenceToStringReturnsNonEmptyString
     * @testdox PaymentReference::__toString() returns numeric string
     */
    public function testPaymentReferenceToStringReturnsNumericString()
    {
        $data_object = new \StoreCore\Types\PaymentReference();
        $data = (string)$data_object;
        $this->assertTrue(is_numeric($data));
    }

    /**
     * @depends testPaymentReferenceToStringReturnsNumericString
     * @testdox PaymentReference::__toString() returns 16 digits
     */
    public function testPaymentReferenceToStringReturnsSixteenDigits()
    {
        $data_object = new \StoreCore\Types\PaymentReference();
        $data = (string)$data_object;
        $this->assertTrue(ctype_digit($data));
        $this->assertTrue(strlen($data) === 16);
    }
}
