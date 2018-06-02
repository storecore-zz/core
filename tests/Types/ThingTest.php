<?php
class ThingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testThingClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'Thing.php');
    }

    /**
     * @group distro
     */
    public function testExtendedAbstractRichSnippetClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'AbstractRichSnippet.php');
    }

    /**
     * @group hmvc
     */
    public function testClassExtendsAbstractRichSnippet()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertTrue($thing instanceof \StoreCore\Types\AbstractRichSnippet);
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsStringableInterface()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertTrue($thing instanceof \StoreCore\Types\StringableInterface);
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Thing');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Types\Thing::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Types\Thing::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\Thing::VERSION);
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Thing');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method returns string
     */
    public function testPublicToStringMethodReturnsString()
    {
        $thing = new \StoreCore\Types\Thing();
        $thing = (string)$thing;
        $this->assertTrue(is_string($thing));
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method returns non-empty string
     */
    public function testPublicToStringMethodReturnsNonEmptyString()
    {
        $thing = new \StoreCore\Types\Thing();
        $thing = (string)$thing;
        $this->assertFalse(empty($thing));
    }
}
