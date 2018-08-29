<?php
class DocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreDocumentClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Document.php');
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Document();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Document');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $class = new \ReflectionClass('\StoreCore\Document');
        $this->assertNotEmpty($class->getConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Document');
        $this->assertTrue(is_string($class->getConstant('VERSION')));
    }

    /**
     * @group distro
     */
    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Document::VERSION);
    }

    /**
     * @group seo
     */
    public function testDocumentAlwaysHasATitle()
    {
        $document = new \StoreCore\Document();
        $this->assertContains('<title>', $document->getHead());
        $this->assertContains('</title>', $document->getHead());
    }

    /**
     * @group seo
     */
    public function testDocumentTitleCanBeSet()
    {
        $title = 'Foo Bar';

        $document = new \StoreCore\Document();
        $this->assertNotContains('Foo Bar', $document->getHead());
        $document->setTitle($title);
        $this->assertContains('<title>Foo Bar</title>', $document->getHead());

        $document = null;

        $document = new \StoreCore\Document($title);
        $this->assertContains('<title>Foo Bar</title>', $document->getHead());
    }

    public function testEmptyBodyHasClosingTag()
    {
        $this->Document = new \StoreCore\Document();
        $this->assertEquals('<body></body>', $this->Document->getBody());
    }
}
