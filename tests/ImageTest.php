<?php
class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testImageClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Image.php');
    }

    /**
     * @group hmvc
     * @testdox \StoreCore\Image implements \StoreCore\Types\StringableInterface
     */
    public function testStoreCoreImageImplementsStoreCoreTypesStringableInterface()
    {
        $image = new \StoreCore\Image();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $image);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Image::VERSION);
        $this->assertInternalType('string', \StoreCore\Image::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Image::VERSION);
    }


    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testPublicToStringMethodExists
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicToStringMethodExists
     * @testdox Image::__toString() returns non-empty string
     */
    public function testImageToStringReturnsNonEmptyString()
    {
        $image = new \StoreCore\Image();

        $this->assertNotEmpty($image->__toString());
        $this->assertInternalType('string', $image->__toString());

        $this->assertNotEmpty((string)$image);
        $this->assertInternalType('string', (string)$image);
    }

    /**
     * @depends testImageToStringReturnsNonEmptyString
     * @testdox Image::__toString() returns <img> tag
     */
    public function testImageToStringReturnsImgTag()
    {
        $image = new \StoreCore\Image();
        $this->assertStringStartsWith('<img ', (string)$image);
        $this->assertEmpty(strip_tags((string)$image));
    }


    /**
     * @testdox Public getAlt() method exists
     */
    public function testPublicGetAltMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('getAlt'));
    }

    /**
     * @testdox Public getAlt() method is public
     */
    public function testPublicGetAltMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getAlt');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getAlt() method has no parameters
     */
    public function testPublicGetAltMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getAlt');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Public getAlt() method returns empty string by default
     */
    public function testPublicGetAltMethodReturnsEmptyStringByDefault()
    {
        $image = new \StoreCore\Image();
        $this->assertEmpty($image->getAlt());
        $this->assertInternalType('string', $image->getAlt());
    }


    /**
     * @testdox Public getHeight() method exists
     */
    public function testPublicGetHeightMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('getHeight'));
    }

    /**
     * @testdox Public getHeight() method is public
     */
    public function testPublicGetHeightMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getHeight');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getHeight() method has no parameters
     */
    public function testPublicGetHeightMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getHeight');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Public getSource() method exists
     */
    public function testPublicGetSourceMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('getSource'));
    }

    /**
     * @testdox Public getSource() method is public
     */
    public function testPublicGetSourceMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getSource');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getSource() method has no parameters
     */
    public function testPublicGetSourceMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getSource');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Public getWidth() method exists
     */
    public function testPublicGetWidthMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('getWidth'));
    }

    /**
     * @testdox Public getWidth() method is public
     */
    public function testPublicGetWidthMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getWidth');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getWidth() method has no parameters
     */
    public function testPublicGetWidthMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'getWidth');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Public setAlt() method exists
     */
    public function testPublicSetAltMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('setAlt'));
    }

    /**
     * @testdox Public setAlt() method is public
     */
    public function testPublicSetAltMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setAlt');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setAlt() method has one required parameter
     */
    public function testPublicSetAltMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setAlt');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Public setHeight() method exists
     */
    public function testPublicSetHeightMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('setHeight'));
    }

    /**
     * @testdox Public setHeight() method is public
     */
    public function testPublicSetHeightMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setHeight');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setHeight() method has one required parameter
     */
    public function testPublicSetHeightMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setHeight');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setHeight() method throws \DomainException on 0 (zero)
     */
    public function testPublicSetHeightMethodThrowsDomainExceptionOnZero()
    {
        $image = new \StoreCore\Image();
        $image->setHeight(0);
    }


    /**
     * @testdox Public setSource() method exists
     */
    public function testPublicSetSourceMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('setSource'));
    }

    /**
     * @testdox Public setSource() method is public
     */
    public function testPublicSetSourceMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setSource');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setSource() method has one required parameter
     */
    public function testPublicSetSourceMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setSource');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Public setWidth() method exists
     */
    public function testPublicSetWidthMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Image');
        $this->assertTrue($class->hasMethod('setWidth'));
    }

    /**
     * @testdox Public setWidth() method is public
     */
    public function testPublicSetWidthMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setWidth');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setWidth() method has one required parameter
     */
    public function testPublicSetWidthMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Image', 'setWidth');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setWidth() method throws \DomainException on 0 (zero)
     */
    public function testPublicSetWidthMethodThrowsDomainExceptionOnZero()
    {
        $image = new \StoreCore\Image();
        $image->setWidth(0);
    }


    /**
     * @testdox Supports 8K UHD image resolutions
     */
    public function testSupports8KUhdImageResolutions()
    {
        $image = new \StoreCore\Image();
        $image->setWidth(7680);
        $image->setHeight(4320);
        $this->assertSame(7680, $image->getWidth());
        $this->assertSame(4320, $image->getHeight());
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setWidth() method throws \DomainException on width over 7680
     */
    public function testPublicSetWidthMethodThrowsDomainExceptionOnWidthOver7680()
    {
        $image = new \StoreCore\Image();
        $image->setWidth(7680 + 1);
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setHeight() method throws \DomainException on height over 4320
     */
    public function testPublicSetHeightMethodThrowsDomainExceptionOnHeightOver4320()
    {
        $image = new \StoreCore\Image();
        $image->setHeight(4320 + 1);
    }
}
