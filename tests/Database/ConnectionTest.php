<?php
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testDatabaseConnectionClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Connection.php');
    }

    /**
     * @group hmvc
     * @testdox Database connection extends \PDO
     */
    public function testDatabaseConnectionExtendsPdo()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Connection');
        $this->assertTrue($class->isSubclassOf('\PDO'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Connection');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Connection::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Connection::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\Database\Connection::VERSION);
    }


    /**
     * @testdox Constructor exists
     */
    public function testConstructorExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Connection');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testConstructorExists
     * @testdox Constructor has three optional parameters
     */
    public function testConstructorHasThreeOptionalParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Connection', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 3);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
