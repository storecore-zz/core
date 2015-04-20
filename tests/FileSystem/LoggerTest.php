<?php
class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function testNullLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Psr/Log/NullLogger.php');
    }

    public function testImplementedLoggerInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Psr/Log/LoggerInterface.php');
    }

    public function testExtendedAbstractLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Psr/Log/AbstractLogger.php');
    }

    public function testFileSystemLoggerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'FileSystem/Logger.php');
    }

    public function testVersionConstantIsDefined()
    {
        $this->assertTrue(defined('\StoreCore\FileSystem\Logger::VERSION'));
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
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Psr/Log/LogLevel.php');
        $this->assertTrue(defined('\Psr\Log\LogLevel::EMERGENCY'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::ALERT'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::CRITICAL'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::ERROR'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::WARNING'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::NOTICE'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::INFO'));
        $this->assertTrue(defined('\Psr\Log\LogLevel::DEBUG'));
    }
}
