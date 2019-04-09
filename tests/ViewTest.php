<?php
/**
 * @group hmvc
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreViewClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'View.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\View');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\View::VERSION);
        $this->assertInternalType('string', \StoreCore\View::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\View::VERSION);
    }


    /**
     * @testdox Constructor exists
     */
    public function testConstructorExists()
    {
        $class = new \ReflectionClass('\StoreCore\View');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @testdox Constructor has one parameter
     * @depends testConstructorExists
     *
     * @todo These tests are basically the same, so we may eventually choose
     *   one of the first two assertions and drop the rest.
     */
    public function testConstructorHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\View', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);

        $class = new \ReflectionClass('\StoreCore\View');
        $constructor = $class->getConstructor();
        $this->assertTrue($constructor->getNumberOfParameters() === 1);

        $this->assertEquals($method, $constructor);
    }


    /**
     * @testdox Public setTemplate() method exists
     */
    public function testPublicSetTemplateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\View');
        $this->assertTrue($class->hasMethod('setTemplate'));
    }

    /**
     * @testdox Public setTemplate() method is public
     * @depends testPublicSetTemplateMethodExists
     */
    public function testPublicSetTemplateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'setTemplate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setTemplate() method has one parameter
     * @depends testPublicSetTemplateMethodExists
     */
    public function testPublicSetTemplateMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'setTemplate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Public setTemplate() method throws \InvalidArgumentException on empty string
     * @depends testPublicSetTemplateMethodExists
     */
    public function testPublicSetTemplateMethodThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $view = new \StoreCore\View();
        $this->assertEmpty($empty_string);
        $view->setTemplate($empty_string);
    }


    /**
     * @testdox Public setValues() method exists
     */
    public function testPublicSetValuesMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\View');
        $this->assertTrue($class->hasMethod('setValues'));
    }

    /**
     * @testdox Public setValues() method is public
     * @depends testPublicSetValuesMethodExists
     */
    public function testPublicSetValuesMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'setValues');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setValues() method has one parameter
     * @depends testPublicSetValuesMethodExists
     */
    public function testPublicSetValuesMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'setValues');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }


    /**
     * @testdox Public render() method exists
     */
    public function testPublicRenderMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\View');
        $this->assertTrue($class->hasMethod('render'));
    }

    /**
     * @testdox Public render() method is public
     * @depends testPublicRenderMethodExists
     */
    public function testPublicRenderMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'render');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public render() method has no parameters
     * @depends testPublicRenderMethodExists
     */
    public function testPublicRenderMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\View', 'render');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
