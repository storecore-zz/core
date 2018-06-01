<?php
/**
 * @coversDefaultClass \StoreCore\Database\Salt
 */
class SaltTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testSaltClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Salt.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Salt');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox CHARACTER_SET constant is defined
     */
    public function testCharacterSetConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Salt');
        $this->assertTrue($class->hasConstant('CHARACTER_SET'));
    }

    /**
     * @testdox Public static getInstance() method exists
     */
    public function testPublicStaticGetInstanceMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Salt');
        $this->assertTrue($class->hasMethod('getInstance'));
    }

    /**
     * @depends testPublicStaticGetInstanceMethodExists
     * @testdox Public static getInstance() method is public
     */
    public function testPublicStaticGetInstanceMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Salt', 'getInstance');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicStaticGetInstanceMethodExists
     * @testdox Public static getInstance() method is static
     */
    public function testPublicStaticGetInstanceMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Salt', 'getInstance');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @depends testPublicStaticGetInstanceMethodIsStatic
     * @testdox Public static getInstance() method returns 255 characters by default
     */
    public function testPublicStaticGetInstanceMethodReturns255CharactersByDefault()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->assertTrue(strlen(\StoreCore\Database\Salt::getInstance()) === 255);
        }
    }

    /**
     * @depends testPublicStaticGetInstanceMethodIsStatic
     * @testdox Public static getInstance() method returns at least 2 characters
     */
    public function testPublicStaticGetInstanceMethodReturnsAtLeast2Characters()
    {
        $this->assertTrue(strlen(\StoreCore\Database\Salt::getInstance()) >= 2);
        $this->assertTrue(strlen(\StoreCore\Database\Salt::getInstance(1)) >= 2);
        $this->assertTrue(strlen(\StoreCore\Database\Salt::getInstance(0)) >= 2);
    }
}
