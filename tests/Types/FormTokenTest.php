<?php
class FormTokenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Core form token class file exists
     */
    public function testCoreFormTokenClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'FormToken.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\FormToken');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     * @depends testVersionConstantIsDefined
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Types\FormToken::VERSION);
    }

    /**
     * @group distro
     * @depends testVersionConstantIsDefined
     */
    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\FormToken::VERSION);
    }

    /**
     * @testdox Public static getInstance() method exists
     */
    public function testPublicStaticGetInstanceMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\FormToken');
        $this->assertTrue($class->hasMethod('getInstance'));
    }

    /**
     * @testdox Public static getInstance() method is public
     */
    public function testPublicStaticGetInstanceMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\FormToken', 'getInstance');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public static getInstance() method is static
     */
    public function testPublicStaticGetInstanceMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\FormToken', 'getInstance');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox Public static getInstance() method returns non-empty string
     * @depends testPublicStaticGetInstanceMethodIsStatic
     */
    public function testPublicStaticGetInstanceMethodReturnsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\FormToken::getInstance());
        $this->assertInternalType('string', \StoreCore\Types\FormToken::getInstance());
    }
}
