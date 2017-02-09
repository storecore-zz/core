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

    public function testAllLogLevelsHaveMethods()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Logger');
        $log_levels = array('emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug');
        foreach ($log_levels as $log_level_method) {
            $this->assertTrue($class->hasMethod($log_level_method));
        }
    }

    public function testAllLogLevelMethodsArePublic()
    {
        $log_levels = array('emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug');
        foreach ($log_levels as $log_level_method) {
            $method = new \ReflectionMethod('\StoreCore\FileSystem\Logger', $log_level_method);
            $this->assertTrue($method->isPublic());
        }
    }

    /**
     * @testdox getLogLevel() method exists
     */
    public function testGetLogLevelMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Logger');
        $this->assertTrue($class->hasMethod('getLogLevel'));
    }

    /**
     * @testdox getMessage() method is public
     */
    public function testGetLogLevelMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Logger', 'getLogLevel');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox getMessage() method exists
     */
    public function testGetMessageMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Logger');
        $this->assertTrue($class->hasMethod('getMessage'));
    }
    /**
     * @testdox getMessage() method is public
     */
    public function testGetMessageMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Logger', 'getMessage');
        $this->assertTrue($method->isPublic());
    }
}
