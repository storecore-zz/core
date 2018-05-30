<?php
class AbstractRichSnippetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testAbstractRichSnippetClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'AbstractRichSnippet.php');
    }

    /**
     * @group hmvc
     */
    public function testAbstractRichSnippetClassImplementsStringableInterface()
    {
        $class = new \ReflectionClass('\StoreCore\Types\AbstractRichSnippet');
        $this->assertTrue($class->implementsInterface('\StoreCore\Types\StringableInterface'));
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\AbstractRichSnippet');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Types\AbstractRichSnippet');
        $class_constant = $class->getConstant('VERSION');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\AbstractRichSnippet::VERSION);
    }

    /**
     * @group hmvc
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\AbstractRichSnippet');
        $this->assertTrue($class->hasMethod('__toString'));
    }
}
