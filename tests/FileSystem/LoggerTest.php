<?php
class LoggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testNullLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Log/NullLogger.php');
    }

    /**
     * @group distro
     */
    public function testImplementedLoggerInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Log/LoggerInterface.php');
    }

    /**
     * @group distro
     */
    public function testExtendedAbstractLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Log/AbstractLogger.php');
    }

    /**
     * @group distro
     */
    public function testFileSystemLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/Logger.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Logger');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\Logger::VERSION);
    }

    /**
     * @testdox RFC 5424 Syslog log levels are supported
     */
    public function testRfc5424SyslogLogLevelsAreSupported()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Log/LogLevel.php');

        $class = new \ReflectionClass('\Psr\Log\LogLevel');
        $this->assertTrue($class->hasConstant('EMERGENCY'));
        $this->assertTrue($class->hasConstant('ALERT'));
        $this->assertTrue($class->hasConstant('CRITICAL'));
        $this->assertTrue($class->hasConstant('ERROR'));
        $this->assertTrue($class->hasConstant('WARNING'));
        $this->assertTrue($class->hasConstant('NOTICE'));
        $this->assertTrue($class->hasConstant('INFO'));
        $this->assertTrue($class->hasConstant('DEBUG'));
    }
}
