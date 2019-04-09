<?php
class DatabaseBlacklistTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testDatabaseBlacklistClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Blacklist.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Blacklist');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Database\Blacklist::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Database\Blacklist::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Blacklist::VERSION);
    }


    /**
     * @testdox Public clear() method exists
     */
    public function testPublicClearMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Blacklist');
        $this->assertTrue($class->hasMethod('clear'));
    }

    /**
     * @testdox Public clear() method is public
     */
    public function testPublicClearMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'clear');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public clear() method has no parameters
     */
    public function testPublicClearMethodHasNoParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'clear');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox Public create() method exists
     */
    public function testPublicCreateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Blacklist');
        $this->assertTrue($class->hasMethod('create'));
    }

    /**
     * @testdox Public create() method is public
     */
    public function testPublicCreateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'create');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public create() method has two parameters
     */
    public function testPublicCreateMethodHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'create');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @testdox Public create() method has one required parameter
     */
    public function testPublicCreateMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'create');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Public delete() method exists
     */
    public function testPublicDeleteMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Blacklist');
        $this->assertTrue($class->hasMethod('delete'));
    }

    /**
     * @testdox Public delete() method is public
     */
    public function testPublicDeleteMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'delete');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public delete() method has one required parameter
     */
    public function testPublicDeleteMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'delete');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Public read() method exists
     */
    public function testPublicReadMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Blacklist');
        $this->assertTrue($class->hasMethod('read'));
    }

    /**
     * @testdox Public read() method is public
     */
    public function testPublicReadMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'read');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public read() method has no parameters
     */
    public function testPublicReadMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Blacklist', 'read');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
