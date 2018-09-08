<?php
class AMPLayoutTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP Layout class file exists
     */
    public function testAmpLayoutClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'Layout.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP Layout class extends AbstractComponent
     */
    public function testAmpLayoutClassExtendsAbstractComponent()
    {
        $object = new \StoreCore\AMP\Layout();
        $this->assertInstanceOf('\StoreCore\AMP\AbstractComponent', $object);
    }

    /**
     * @group hmvc
     * @testdox AMP Layout class implements LayoutInterface
     */
    public function testAmpLayoutClassImplementsLayoutInterface()
    {
        $object = new \StoreCore\AMP\Layout();
        $this->assertInstanceOf('\StoreCore\AMP\LayoutInterface', $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Layout');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\Layout::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\Layout::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches development branch
     */
    public function testVersionConstantMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\Layout::VERSION);
    }


    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Layout');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testPublicToStringMethodExists
     * @testdox Public __toString() method returns non-empty string
     */
    public function testPublicToStringMethodReturnsNonEmptyString()
    {
        $component = new \StoreCore\AMP\Layout();
        $string = (string)$component;
        $this->assertNotEmpty($string);
        $this->assertInternalType('string', $string);
    }

    /**
     * @depends testPublicToStringMethodReturnsNonEmptyString
     * @testdox Public __toString() method returns <amp-layout> HTML container
     */
    public function testPublicToStringMethodReturnsAmpLayoutHtmlContainer()
    {
        $component = new \StoreCore\AMP\Layout();
        $amp_html = (string)$component;
        $this->assertStringStartsWith('<amp-layout', $amp_html);
        $this->assertStringEndsWith('</amp-layout>', $amp_html);
        $this->assertEmpty(strip_tags($amp_html));
    }


    /**
     * @group hmvc
     * @testdox AMP LayoutInterface::LAYOUT_RESPONSIVE constant exists
     */
    public function testAmpLayoutInterfaceLayoutResponsiveConstantExists()
    {
        $this->assertNotEmpty(\StoreCore\AMP\LayoutInterface::LAYOUT_RESPONSIVE);
    }

    /**
     * @testdox AMP Layout component has responsive layout by default
     */
    public function testAmpLayoutComponentHasResponsiveLayoutByDefault()
    {
        $component = new \StoreCore\AMP\Layout();
        $this->assertEquals(\StoreCore\AMP\LayoutInterface::LAYOUT_RESPONSIVE, $component->getLayout());
    }


    /**
     * @group hmvc
     * @testdox AMP LayoutInterface::LAYOUT_NODISPLAY constant exists
     */
    public function testAmpLayoutInterfaceLayoutNodisplayConstantExists()
    {
        $this->assertNotEmpty(\StoreCore\AMP\LayoutInterface::LAYOUT_NODISPLAY);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Public setLayout() method does not support "nodisplay" layout
     */
    public function testPublicSetLayoutMethodDoesNotSupportNodisplayLayout()
    {
        $component = new \StoreCore\AMP\Layout();
        $component->setLayout(\StoreCore\AMP\LayoutInterface::LAYOUT_NODISPLAY);
    }


    /**
     * @testdox AMP Layout component default width is 1
     */
    public function testAmpLayoutComponentDefaultWidthIsOne()
    {
        $layout_component = new \StoreCore\AMP\Layout();
        $this->assertEquals('1', $layout_component->width);
        $this->assertContains(' width="1"', (string)$layout_component);
    }

    /**
     * @testdox AMP Layout component default height is 1
     */
    public function testAmpLayoutComponentDefaultHeightIsOne()
    {
        $layout_component = new \StoreCore\AMP\Layout();
        $this->assertEquals('1', $layout_component->height);
        $this->assertContains(' height="1"', (string)$layout_component);
    }
}
