<?php
namespace StoreCore\FileSystem;

use \Psr\Log\AbstractLogger as AbstractLogger;
use \Psr\Log\LogLevel as LogLevel;

/**
 * File System Logger
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Logger extends AbstractLogger
{
    const VERSION = '0.1.0';

    /** @type resource $Handle */
    private $Handle;

    /** @type string $Filename */
    private $Filename;

    /** @type string $OutputBuffer */
    private $OutputBuffer = '';

    /**
     * @param string $filename
     *   Optional name of the log file, with or without a trailing path.  If
     *   the filename is not set, it defaults to the YYYYMMDDHH.log format with
     *   a YYYY-MM-DD date and HH hours for hourly log files.
     *
     * @return void
     */
    public function __construct($filename = null)
    {
        if ($filename == null) {
            if (defined('STORECORE_FILESYSTEM_LOGS_FILENAME_FORMAT')) {
                $filename = gmdate(STORECORE_FILESYSTEM_LOGS_FILENAME_FORMAT) . '.log';
            } else {
                $filename = gmdate('YmdH') . '.log';
            }
            if (defined('STORECORE_FILESYSTEM_LOGS_DIR')) {
                $filename = STORECORE_FILESYSTEM_LOGS_DIR . $filename;
            }
        }
        $this->Filename = $filename;
    }

    /**
     * @param void
     * @return void
     */
    public function __destruct()
    {
        $this->flush();
        if (is_resource($this->Handle)) {
            fclose($this->Handle);
        }
    }

    /**
     * Write to the log file and flush the output buffer.
     *
     * @param void
     * @return void
     */
    public function flush()
    {
        if (empty($this->OutputBuffer)) {
            return;
        }

        if (!is_resource($this->Handle)) {
            $this->Handle = fopen($this->Filename, 'a');
        }
        if ($this->Handle !== false) {
            fwrite($this->Handle, $this->OutputBuffer);
            $this->OutputBuffer = (string)null;
        }
    }

    /**
     * Log an event.
     *
     * @param \Psr\Log\LogLevel $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        // ISO date and time plus log level
        $output = '[' . date(DATE_ISO8601) . '] [' . $level . '] ';

        // Client
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $output .= '[client ' . $_SERVER['REMOTE_ADDR'] . '] ';
        }

        // Log message
        $output .= $message;

        // Optional context
        if (count($context) > 0) {
            $output .= ' [context ' . print_r($context, true) . ']';
        }

        // End Of Line (EOL)
        $output .= PHP_EOL;

        // Add the output to the output buffer
        $this->OutputBuffer .= $output;

        // Notify observers
        if ($level == LogLevel::EMERGENCY || $level == LogLevel::ALERT) {
            $this->notify();
        }
    }
}
