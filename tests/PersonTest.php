<?php
class PersonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testPersonClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Person.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Person');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public getDateDeleted() method exists
     */
    public function testPublicGetDateDeletedMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Person');
        $this->assertTrue($class->hasMethod('getDateDeleted'));
    }

    /**
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method is public
     */
    public function testPublicGetDateDeletedMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'getDateDeleted');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method has no parameters
     */
    public function testPublicGetDateDeletedMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'getDateDeleted');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method returns null by default
     */
    public function testPublicGetDateDeletedMethodReturnsNullByDefault()
    {
        $object = new \StoreCore\Person();
        $this->assertNull($object->getDateDeleted());
    }

    /**
     * @testdox Public setDateDeleted() method exists
     */
    public function testPublicSetDateDeletedMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Person');
        $this->assertTrue($class->hasMethod('setDateDeleted'));
    }

    /**
     * @depends testPublicSetDateDeletedMethodExists
     * @testdox Public setDateDeleted() method is public
     */
    public function testPublicSetDateDeletedMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicSetDateDeletedMethodExists
     * @testdox Public setDateDeleted() method has one parameter
     */
    public function testPublicSetDateDeletedMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testPublicSetDateDeletedMethodHasOneParameter
     * @testdox Public setDateDeleted() method has one required parameter
     */
    public function testPublicSetDateDeletedMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testPublicGetDateDeletedMethodExists
     * @depends testPublicSetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method returns datetime string
     */
    public function testPublicGetDateDeletedMethodReturnsDatetimeString()
    {
        $now = gmdate('Y-m-d H:i:s');
        $object = new \StoreCore\Person();
        $object->setDateDeleted($now);
        $this->assertEquals($now, $object->getDateDeleted());
    }
}
