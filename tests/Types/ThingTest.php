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
     * @testdox Class extends AbstractRichSnippet
     */
    public function testClassExtendsAbstractRichSnippet()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertInstanceOf(\StoreCore\Types\AbstractRichSnippet::class, $thing);
    }

    /**
     * @group hmvc
     * @testdox Class implements StringableInterface
     */
    public function testClassImplementsStringableInterface()
    {
        $thing = new \StoreCore\Types\Thing();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $thing);
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
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\Thing::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\Thing::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testox VERSION matches master branch
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
     * @testdox Thing::__toString() method returns string
     */
    public function testThingToStringReturnsString()
    {
        $thing = new \StoreCore\Types\Thing();
        $thing = (string) $thing;
        $this->assertInternalType('string', $thing);
    }

    /**
     * @group hmvc
     * @testdox Thing::__toString() returns non-empty string
     */
    public function testThingToStringReturnsNonEmptyString()
    {
        $thing = new \StoreCore\Types\Thing();
        $thing = (string)$thing;
        $this->assertNotEmpty($thing);
        $this->assertInternalType('string', $thing);
    }
}
