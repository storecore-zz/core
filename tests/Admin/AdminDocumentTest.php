<?php
/**
 * @todo
 *   This test class should be called `DocumentTest` and be saved in the
 *   `/tests/Admin/Document.php` file as it is intended to unit test the
 *   `\StoreCore\Admin\Document` class.  This, however, leads to PHPUnit
 *   conflicts with the extended parent class `\StoreCore\Document` and
 *   the accompanying test class file `/tests/DocumentTest.php`.  For now
 *   we fixed this issue by adding the `Admin` prefix.
 */
class AdminDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testAdminDocumentClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/Document.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Document');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\Document::VERSION);
    }

    /**
     * @group seo
     */
    public function testDefaultTitleIsProjectName()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<title>StoreCore</title>', $document->getHead());
    }

    /**
     * @group seo
     */
    public function testRobotsMustNotIndexAdminPages()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<meta name="robots" content="noindex,nofollow">', $document->getHead());
    }

    public function testAdminDocumentUsesFontsFromCdn()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">', $document->getHead());
    }

    public function testAdminDocumentUsesMinifiedIconsFromCdn()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">', $document->getHead());
    }

    public function testAdminDocumentUsesMinifiedCssFromAssets()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="/css/admin.min.css" rel="stylesheet">', $document->getHead());
    }
}
