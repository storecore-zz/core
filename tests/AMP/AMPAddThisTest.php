<?php
class AMPAddThisTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP AddThis class file exists
     */
    public function testAmpAddThisClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'AddThis.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP AddThis class extends AbstractComponent
     */
    public function testAmpAddThisClassExtendsAbstractComponent()
    {
        $object = new \StoreCore\AMP\AddThis();
        $this->assertInstanceOf('\StoreCore\AMP\AbstractComponent', $object);
    }

    /**
     * @group hmvc
     * @testdox AMP AddThis class implements LayoutInterface
     */
    public function testAmpAddThisClassImplementsLayoutInterface()
    {
        $object = new \StoreCore\AMP\AddThis();
        $this->assertInstanceOf('\StoreCore\AMP\LayoutInterface', $object);
    }

    /**
     * @group hmvc
     * @testdox AMP AddThis class implements StringableInterface
     */
    public function testAmpAddThisClassImplementsStringableInterface()
    {
        $object = new \StoreCore\AMP\AddThis();
        $this->assertInstanceOf('\StoreCore\Types\StringableInterface', $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AddThis');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\AddThis::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\AMP\AddThis::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox Version matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\AddThis::VERSION);
    }


    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AddThis');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method returns non-empty string
     */
    public function testPublicToStringMethodReturnsNonEmptyString()
    {
        $object = new \StoreCore\AMP\AddThis();
        $add_this_html = (string)$object;
        $this->assertNotEmpty($add_this_html);
        $this->assertInternalType('string', $add_this_html);
    }

    /**
     * @testdox Public __toString() method returns HTML tags only
     */
    public function testPublicToStringMethodReturnsHtmlTagsOnly()
    {
        $object = new \StoreCore\AMP\AddThis();
        $add_this_html = (string)$object;
        $add_this_html = strip_tags($add_this_html);
        $this->assertEmpty($add_this_html);
    }


    /**
     * @testdox Public setPublisherID() method exists
     */
    public function testPublicSetPublisherIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AddThis');
        $this->assertTrue($class->hasMethod('setPublisherID'));
    }

    /**
     * @testdox Public setPublisherID() method is public
     */
    public function testPublicSetPublisherIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AddThis', 'setPublisherID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setPublisherID() method has one parameter
     */
    public function testPublicSetPublisherIdMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AddThis', 'setPublisherID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @testdox Public setPublisherID() method sets data-pub-id attribute
     */
    public function testPublicSetPublisherIdMethodSetsDataPubIdAttribute()
    {
        $add_this_component = new \StoreCore\AMP\AddThis();
        $this->assertEmpty($add_this_component->__get('data-pub-id'));

        $add_this_component->setPublisherID('ra-59c2c366435ef478');
        $this->assertNotEmpty($add_this_component->__get('data-pub-id'));
        $this->assertEquals('ra-59c2c366435ef478', $add_this_component->__get('data-pub-id'));

        $add_this_amp_html = (string)$add_this_component;
        $this->assertContains(' data-pub-id="ra-59c2c366435ef478"', $add_this_amp_html);
    }


    /**
     * @testdox Public setWidgetID() method exists
     */
    public function testPublicSetWidgetIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AddThis');
        $this->assertTrue($class->hasMethod('setWidgetID'));
    }

    /**
     * @testdox Public setWidgetID() method is public
     */
    public function testPublicSetWidgetIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AddThis', 'setWidgetID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setWidgetID() method has one parameter
     */
    public function testPublicSetWidgetIdMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AddThis', 'setWidgetID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @testdox Public setWidgetID() method sets data-widget-id attribute
     */
    public function testPublicSetWidgetIdMethodSetsDataWidgetIdAttribute()
    {
        $add_this_component = new \StoreCore\AMP\AddThis();
        $this->assertEmpty($add_this_component->__get('data-widget-id'));

        $add_this_component->setWidgetID('0fyg');
        $this->assertNotEmpty($add_this_component->__get('data-widget-id'));
        $this->assertEquals('0fyg', $add_this_component->__get('data-widget-id'));

        $add_this_amp_html = (string)$add_this_component;
        $this->assertContains(' data-widget-id="0fyg"', $add_this_amp_html);
    }

    /**
     * @testdox Class constructor has two parameters
     */
    public function testClassConstructorHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AddThis', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testClassConstructorHasTwoParameters
     * @testdox Class accepts publisher ID and widget ID
     */
    public function testClassConstructorAcceptsPublisherIdAndWidgetId()
    {
        $object = new \StoreCore\AMP\AddThis('ra-59c2c366435ef478', '0fyg');
        $string = (string)$object;
        $this->assertContains(' data-pub-id="ra-59c2c366435ef478"', $string);
        $this->assertContains(' data-widget-id="0fyg"', $string);
    }
}
