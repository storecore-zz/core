<?php
class LocationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Location model class file exists
     */
    public function testLocationModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Location.php');
    }

    /**
     * @group hmvc
     * @testdox Location model extends \StoreCore\AbstractModel
     */
    public function testLocationModelExtendsStoreCoreAbstractModel()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\AbstractModel', $location);
    }

    /**
     * @group hmvc
     * @testdox Location model implements \StoreCore\Types\StringableInterface
     */
    public function testLocationModelImplementsStoreCoreTypesStringableInterface()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\Types\StringableInterface', $location);
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Location::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Location::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Store::VERSION);
    }


    /**
     * @testdox Public set() method exists
     */
    public function testPublicSetMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('set'));
    }

    /**
     * @testdox Public set() method is public
     */
    public function testPublicSetMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'set');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public set() method has one parameter
     */
    public function testPublicSetMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'set');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }


    /**
     * @testdox Public get() method exists
     */
    public function testPublicGetMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('get'));
    }

    /**
     * @testdox Public get() method is public
     */
    public function testPublicGetMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'get');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public get() method has no parameters
     */
    public function testPublicGetMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'get');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Public get() method returns string
     */
    public function testPublicGetMethodReturnsString()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertTrue(is_string($location->get()));
    }

    /**
     * @depends testPublicGetMethodReturnsString
     * @testdox Public get() method returns non-empty string
     */
    public function testPublicGetMethodReturnsNonEmptyString()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertFalse(empty($location->get()));
    }

    /**
     * @depends testPublicGetMethodReturnsNonEmptyString
     * @testdox Public get() method returns strings starting with two slashes (//)
     */
    public function testPublicGetMethodReturnsStringsStartingWithTwoSlashes()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertStringStartsWith('//', $location->get());

        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location->set('https://www.example.com/category/product');
        $this->assertStringStartsWith('//', $location->get());
    }


    /**
     * @depends testPublicSetMethodExists
     * @depends testPublicGetMethodExists
     * @group seo
     * @testdox HTTP and HTTPS point to same location
     */
    public function testHttpAndHttpsPointToSameLocation()
    {
        $location_with_ssl = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location_sans_ssl = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location_with_ssl->set('https://www.example.com/foo/bar');
        $location_sans_ssl->set('http://www.example.com/foo/bar');

        $this->assertEquals($location_sans_ssl->get(), $location_with_ssl->get());
        $this->assertEquals($location_with_ssl->get(), $location_sans_ssl->get());
    }

    /**
     * @depends testPublicSetMethodExists
     * @depends testPublicGetMethodExists
     * @depends testLocationModelImplementsStoreCoreTypesStringableInterface
     * @group seo
     */
    public function testLocationsAreConvertedToLowercase()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location->set('https://www.example.com/Foo/Bar/BAZ-Qux');
        $this->assertEquals('//www.example.com/foo/bar/baz-qux', $location->get());
        $this->assertEquals('//www.example.com/foo/bar/baz-qux', (string)$location);
    }

    /**
     * @depends testPublicSetMethodExists
     * @depends testPublicGetMethodExists
     * @testdox Common index file names are stripped
     */
    public function testCommonIndexFileNamesAreStripped()
    {
        $filenames = array(
            'default.asp',
            'default.aspx',
            'default.htm',
            'default.html',
            'home.htm',
            'home.html',
            'index.cgi',
            'index.dhtml',
            'index.htm',
            'index.html',
            'index.shtml',
            'index.php',
            'index.pl',
        );

        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        foreach ($filenames as $filename) {
            $location->set('https://www.example.com/foo/bar/' . $filename);
            $this->assertEquals('//www.example.com/foo/bar/', $location->get());
        }
    }

    /**
     * @depends testPublicSetMethodExists
     * @depends testPublicGetMethodExists
     * @testdox Common breadcrumb separators are converted to slashes
     */
    public function testCommonBreadcrumbSeparatorsAreConvertedToSlashes()
    {
        $breadcrumbs = array(
            'https://m.example.com/ games / playstation',
            'https://m.example.com/ games \ playstation',
            'https://m.example.com/ games | playstation',
            'https://m.example.com/ games > playstation',
            'https://m.example.com/ games >> playstation',
            'https://m.example.com/ games » playstation',

            'https://m.example.com/games/playstation',
            'https://m.example.com/games\playstation',
            'https://m.example.com/games|playstation',
            'https://m.example.com/games>playstation',
            'https://m.example.com/games>>playstation',
            'https://m.example.com/games»playstation',
        );

        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        foreach ($breadcrumbs as $breadcrumb) {
            $location->set($breadcrumb);
            $this->assertEquals('//m.example.com/games/playstation', $location->get());
        }
    }

    /**
     * @depends testPublicSetMethodExists
     * @depends testPublicGetMethodReturnsNonEmptyString
     * @depends testLocationsAreConvertedToLowercase
     * @testdox Accents and diacritics are converted to ASCII
     */
    public function testAccentsAndDiacriticsAreConvertedToAscii()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location->set('https://www.example.com/Bordeaux/Cru Classé/Château Rauzan-Ségla 2012');
        $this->assertEquals('//www.example.com/bordeaux/cru-classe/chateau-rauzan-segla-2012', $location->get());
    }

    /**
     * @depends testAccentsAndDiacriticsAreConvertedToAscii
     * @testdox Round brackets are removed
     */
    public function testRoundBracketsAreRemoved()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $location->set('https://www.example.com/Bordeaux/Premier Grand Cru Classé (Médoc)');
        $this->assertEquals('//www.example.com/bordeaux/premier-grand-cru-classe-medoc', $location->get());
    }
}
