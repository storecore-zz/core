<?php
class AMPCarouselTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP carousel class file exists
     */
    public function testAMPCarouselClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'Carousel.php'
        );
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\AMP\LayoutInterface interface file exists
     */
    public function testImplementedStoreCoreAmpLayoutInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'LayoutInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP carousel implements \StoreCore\AMP\LayoutInterface
     */
    public function testAmpImageImplementsStoreCoreAmpLayoutInterface()
    {
        $object = new \StoreCore\AMP\Carousel();
        $this->assertInstanceOf(\StoreCore\AMP\LayoutInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\AMP\LightboxGalleryInterface interface file exists
     */
    public function testImplementedStoreCoreAmpLightboxGalleryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'LightboxGalleryInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP carousel implements \StoreCore\AMP\LightboxGalleryInterface
     */
    public function testAmpCarouselImplementsStoreCoreAmpLightboxGalleryInterface()
    {
        $object = new \StoreCore\AMP\Carousel();
        $this->assertInstanceOf(\StoreCore\AMP\LightboxGalleryInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\Types\StringableInterface interface file exists
     */
    public function testImplementedStoreCoreTypesStringableInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'StringableInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP carousel implements \StoreCore\Types\StringableInterface
     */
    public function testAmpCarouselImplementsStoreCoreTypesStringableInterface()
    {
        $object = new \StoreCore\AMP\Carousel();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\Carousel::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\Carousel::VERSION);
    }

    /**
     * @depends testVersionConstantIsNotEmpty
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\Carousel::VERSION);
    }


    /**
     * @group hmvc
     * @testdox Carousel::__toString() exists
     */
    public function testCarouselToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testCarouselToStringExists
     * @group hmvc
     * @testdox Carousel::__toString() returns non-empty string
     */
    public function testCarouselToStringReturnsNonEmptyString()
    {
        $object = new \StoreCore\AMP\Carousel();
        $html = (string)$object;
        $this->assertNotEmpty($html);
        $this->assertInternalType('string', $html);
    }

    /**
     * @depends testCarouselToStringReturnsNonEmptyString
     * @group hmvc
     * @testdox Carousel::__toString() returns HTML tag
     */
    public function testCarouselToStringReturnsHtmlTag()
    {
        $object = new \StoreCore\AMP\Carousel();
        $html = (string)$object;
        $this->assertNotEmpty($html);
        $html = strip_tags($html);
        $this->assertEmpty($html);
    }

    /**
     * @depends testCarouselToStringReturnsNonEmptyString
     * @group hmvc
     * @testdox Carousel::__toString() returns <amp-carousel> tag
     */
    public function testCarouselToStringReturnsAmpCarouselTag()
    {
        $object = new \StoreCore\AMP\Carousel();
        $html = (string)$object;
        $this->assertStringStartsWith('<amp-carousel ', $html);
        $this->assertStringEndsWith('</amp-carousel>', $html);
    }


    /**
     * @testdox Carousel has Autoplay property
     */
    public function testCarouselHasAutoplayProperty()
    {
        $this->assertClassHasAttribute('Autoplay', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setAutoplay() exists
     */
    public function testCarouselSetAutoplayExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setAutoplay'));
    }

    /**
     * @testdox Carousel::setAutoplay() is public
     */
    public function testCarouselSetAutoplayIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setAutoplay');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox Carousel has Children property
     */
    public function testCarouselHasChildrenProperty()
    {
        $this->assertClassHasAttribute('Children', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::append() exists
     */
    public function testCarouselAppendExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('append'));
    }

    /**
     * @depends testCarouselAppendExists
     * @testdox Carousel::append() is public
     */
    public function testCarouselAppendIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'append');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Carousel::append() has one required parameter
     */
    public function testCarouselAppendHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'append');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testCarouselAppendExists
     * @testdox Carousel::append() returns node count
     */
    public function testCarouselAppendReturnsNodeCount()
    {
        $child_node = '<div>...</div>';
        $carousel = new \StoreCore\AMP\Carousel();
        $this->assertEquals(1, $carousel->append($child_node));
        $this->assertEquals(2, $carousel->append($child_node));
        $this->assertEquals(3, $carousel->append($child_node));
    }


    /**
     * @testdox Carousel has Delay property
     */
    public function testCarouselHasDelayProperty()
    {
        $this->assertClassHasAttribute('Delay', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setDelay() method exists
     */
    public function testPublicSetDelayMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setDelay'));
    }

    /**
     * @testdox Carousel::setDelay() is public
     */
    public function testCarouselSetDelayIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setDelay');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Carousel::setDelay() has one required parameter
     */
    public function testCarouselSetDelayHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setDelay');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Carousel has Height property
     */
    public function testCarouselHasHeightProperty()
    {
        $this->assertClassHasAttribute('Height', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setHeight() exists
     */
    public function testCarouselSetHeightExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setHeight'));
    }

    /**
     * @testdox Carousel::setHeight() is public
     */
    public function testCarouselSetHeightIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setHeight');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Carousel::setHeight() has one required parameter
     */
    public function testCarouselSetHeightHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setHeight');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Carousel has Type property
     */
    public function testCarouselHasTypeProperty()
    {
        $this->assertClassHasAttribute('Type', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setType() exists
     */
    public function testCarouselSetTypeExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setType'));
    }

    /**
     * @testdox Carousel::setType() is public
     */
    public function testCarouselSetTypeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setType');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCarouselSetTypeExists
     * @testdox Carousel::setType() has one required parameter
     */
    public function testCarouselSetTypeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setType');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Carousel::setType() throws \InvalidArgumentException on empty string
     */
    public function testCarouselSetTypeThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $carousel = new \StoreCore\AMP\Carousel();
        $this->assertEmpty($empty_string);
        $carousel->setType($empty_string);
    }


    /**
     * @testdox Carousel has Width property
     */
    public function testCarouselHasWidthProperty()
    {
        $this->assertClassHasAttribute('Width', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setWidth() exists
     */
    public function testCarouselSetWidthExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setWidth'));
    }

    /**
     * @depends testCarouselSetWidthExists
     * @testdox Carousel::setWidth() is public
     */
    public function testCarouselSetWidthIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setWidth');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCarouselSetWidthExists
     * @testdox Carousel::setWidth() has one required parameter
     */
    public function testCarouselSetWidthHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setWidth');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
