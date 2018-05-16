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

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Document');
        $this->assertTrue($class->hasConstant('VERSION'));
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

    /**
     * @testdox Admin document uses Roboto fonts from Google CDN
     */
    public function testAdminDocumentUsesRobotoFontsFromGoogleCdn()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">', $document->getHead());
    }

    /**
     * @testdox Admin document uses Material Icons from Google CDN
     */
    public function testAdminDocumentUsesMaterialIconsFromGoogleCdn()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">', $document->getHead());
    }

    /**
     * @testdox Admin document uses minified Material admin CSS from assets
     */
    public function testAdminDocumentUsesMinifiedMaterialAdminCssFromAssets()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertContains('<link href="/styles/admin.min.css" rel="stylesheet">', $document->getHead());
    }

    /**
     * @testdox Public getBody() method exists
     */
    public function testPublicGetBodyMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Document');
        $this->assertTrue($class->hasMethod('getBody'));
    }

    /**
     * @testdox Public getBody() method is public
     */
    public function testPublicGetBodyMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Document', 'getBody');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getBody() method returns MDC start tag
     */
    public function testPublicGetBodyMethodReturnsMdcStartTag()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertStringStartsWith('<body class="mdc-typography">', $document->getBody());
    }

    /**
     * @testdox Public getBody() method returns closing tag
     */
    public function testPublicGetBodyMethodReturnsClosingTag()
    {
        $document = new \StoreCore\Admin\Document();
        $this->assertStringEndsWith('</body>', $document->getBody());
    }
}
