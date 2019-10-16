<?php
class RedirectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Redirect class file exists
     */
    public function testRedirectClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types/Redirect.php');
    }

    /**
     * @group hmvc
     * @testdox Redirect class is concrete
     */
    public function testRedirectClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Redirect');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox Redirect extends PSR-6 Cache AbstractCacheItem
     */
    public function testRedirectExtendsPsr6CacheAbstractCacheItem()
    {
        $object = new \StoreCore\Types\Redirect();
        $this->assertInstanceOf(\Psr\Cache\AbstractCacheItem::class, $object);
    }

    /**
     * @group hmvc
     * @testdox Redirect implements PSR-6 Cache AbstractCacheItem
     */
    public function testRedirectImplementsPsr6CacheAbstractCacheItem()
    {
        $object = new \StoreCore\Types\Redirect();
        $this->assertInstanceOf(\Psr\Cache\AbstractCacheItem::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Redirect');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\Redirect::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\Redirect::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\Redirect::VERSION);
    }


    /**
     * @testdox Redirect::__construct() exists
     */
    public function testRedirectConstructorExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Redirect');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testRedirectConstructorExists
     * @testdox Redirect::__construct() is public
     */
    public function testRedirectConstructorIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\Redirect', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRedirectConstructorExists
     * @testdox Redirect::__construct() has two optional parameters
     */
    public function testRedirectConstructorHasTwoOptionalParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\Redirect', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox Redirect::redirect() exists
     */
    public function testRedirectRedirectExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\Redirect');
        $this->assertTrue($class->hasMethod('redirect'));
    }

    /**
     * @depends testRedirectRedirectExists
     * @testdox Redirect::redirect() is public
     */
    public function testRedirectRedirectIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\Redirect', 'redirect');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRedirectRedirectExists
     * @testdox Redirect::redirect() has one optional parameter
     */
    public function testRedirectRedirectHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\Redirect', 'redirect');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }

    /**
     * @depends testRedirectRedirectHasOneOptionalParameter
     * @expectedException \InvalidArgumentException
     * @testdox Redirect::redirect() throws \InvalidArgumentException on numeric string
     */
    public function testRedirectRedirectThrowsInvalidArgumentExceptionOnNumericString()
    {
        $redirect = new \StoreCore\Types\Redirect();
        $redirect->redirect('301');
    }

    /**
     * @depends testRedirectRedirectHasOneOptionalParameter
     * @expectedException \DomainException
     * @testdox Redirect::redirect() throws \DomainException below (int) 300
     */
    public function testRedirectRedirectThrowsDomainExceptionBelowInt300()
    {
        $redirect = new \StoreCore\Types\Redirect();
        $redirect->redirect(299);
    }

    /**
     * @depends testRedirectRedirectHasOneOptionalParameter
     * @expectedException \DomainException
     * @testdox Redirect::redirect() throws \DomainException above (int) 308
     */
    public function testRedirectRedirectThrowsDomainExceptionAboveInt308()
    {
        $redirect = new \StoreCore\Types\Redirect();
        $redirect->redirect(309);
    }
}
