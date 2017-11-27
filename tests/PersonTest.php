<?php
/**
 * @coversDefaultClass \StoreCore\Person
 */
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
     * @covers ::getDateDeleted
     * @testdox Public getDateDeleted() method exists
     */
    public function testPublicGetDateDeletedMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Person');
        $this->assertTrue($class->hasMethod('getDateDeleted'));
    }

    /**
     * @covers ::getDateDeleted
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method is public
     */
    public function testPublicGetDateDeletedMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'getDateDeleted');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers ::getDateDeleted
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method has no parameters
     */
    public function testPublicGetDateDeletedMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'getDateDeleted');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @covers ::getDateDeleted
     * @depends testPublicGetDateDeletedMethodExists
     * @testdox Public getDateDeleted() method returns null by default
     */
    public function testPublicGetDateDeletedMethodReturnsNullByDefault()
    {
        $object = new \StoreCore\Person();
        $this->assertNull($object->getDateDeleted());
    }

    /**
     * @covers ::setDateDeleted
     * @testdox Public setDateDeleted() method exists
     */
    public function testPublicSetDateDeletedMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Person');
        $this->assertTrue($class->hasMethod('setDateDeleted'));
    }

    /**
     * @covers ::setDateDeleted
     * @depends testPublicSetDateDeletedMethodExists
     * @testdox Public setDateDeleted() method is public
     */
    public function testPublicSetDateDeletedMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers ::setDateDeleted
     * @depends testPublicSetDateDeletedMethodExists
     * @testdox Public setDateDeleted() method has one parameter
     */
    public function testPublicSetDateDeletedMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @covers ::setDateDeleted
     * @depends testPublicSetDateDeletedMethodHasOneParameter
     * @testdox Public setDateDeleted() method has one required parameter
     */
    public function testPublicSetDateDeletedMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Person', 'setDateDeleted');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @covers ::getDateDeleted
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
