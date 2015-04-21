<?php
class DocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreDocumentClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Document.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Document');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Document::VERSION);
    }

    /**
     * @group seo
     */
    public function testDocumentHasNoTitleIfNoneWasSet()
    {
        $document = new \StoreCore\Document();
        $this->assertNotContains('<title>', $document->getHead());
        $this->assertNotContains('</title>', $document->getHead());
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

    public function testEmptyBodyHasWrapper()
    {
        $this->Document = new \StoreCore\Document();
        $this->assertContains('<div id="wrapper"></div>', $this->Document->getBody());
        $this->assertEquals('<body><div id="wrapper"></div></body>', $this->Document->getBody());
    }
}
