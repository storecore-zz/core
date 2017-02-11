<?php
namespace StoreCore\FileSystem;

use \Psr\Log\AbstractLogger as AbstractLogger;
use \Psr\Log\LogLevel as LogLevel;
use \StoreCore\ObserverInterface as ObserverInterface;
use \StoreCore\SubjectInterface as SubjectInterface;

/**
 * File System Logger
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2014-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Logger extends AbstractLogger implements SubjectInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /** @var resource $Handle */
    private $Handle;

    /** @var string $Filename */
    private $Filename;

    /** @var string|null $LogLevel */
    private $LogLevel;

    /** @var string|null $Message */
    private $Message;

    /** @var array|null $Observers */
    private $Observers;

    /**
     * @param string $filename
     *   Optional name of the log file, with or without a trailing path.  If
     *   the filename is not set, it defaults to the YYYYMMDDHH.log format with
     *   a YYYY-MM-DD date and HH hours for hourly log files.
     *
     * @return self
     */
    public function __construct($filename = null)
    {
        if ($filename === null) {
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
     * Attach a log or logging observer.
     *
     * Observers are notified when a LogLevel::EMERGENCY or LogLevel::ALERT
     * event occurs.  This allows some other process or agent to handle
     * critical events, for example by sending a message to administrators.
     *
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function attach(ObserverInterface $observer)
    {
        if ($this->Observers === null) {
            $this->Observers = array();
        }
        $id = spl_object_hash($observer);
        $this->Observers[$id] = $observer;
    }

    /**
     * Detach an observer.
     *
     * @param \StoreCore\ObserverInterface $observer
     *
     * @return void
     *
     * @uses \Psr\Log\AbstractLogger::notice()
     *   Because important or critical events may go unnoticed for some time
     *   once an observer is detached from a logger, a notice is logged and
     *   saved to the current logger's log file.  The remaining observers
     *   (if any) are also notified of the update.
     */
    public function detach(ObserverInterface $observer)
    {
        $this->notice('Detaching observer class ' . get_class($observer) . '.');
        $id = spl_object_hash($observer);
        unset($this->Observers[$id]);
        $this->notify();
    }

    /**
     * Get the filename of the log file.
     *
     * @param void
     *
     * @return string
     *   Returns the filename of the log file including the full path.
     */
    public function getFilename()
    {
        return $this->Filename;
    }

    /**
     * Get the last log message.
     *
     * @param void
     *
     * @return string|null
     *   Returns the last log message for the current process/request or null
     *   if there are no messages.  The main purpose of this method is allowing
     *   observers access to critical events.
     */
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * Get the last log level.
     *
     * @param void
     *
     * @return \Psr\Log\LogLevel
     *   Returns the last log level for the current process/request or null
     *   if there are no logged events.
     */
    public function getLogLevel()
    {
        return $this->LogLevel;
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
        $this->LogLevel = $level;
        $output = '[' . date(DATE_ISO8601) . '] [' . $level . '] ';

        // Client
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $output .= '[client ' . $_SERVER['REMOTE_ADDR'] . '] ';
        }

        // Log message
        $this->Message = $message;
        $output .= $message;

        // Optional context
        if (count($context) > 0) {
            $output .= ' [context ' . print_r($context, true) . ']';
        }

        // End Of Line (EOL)
        $output .= PHP_EOL;

        // Log the message.
        if (!is_resource($this->Handle)) {
            $this->Handle = fopen($this->Filename, 'a');
        }
        if ($this->Handle !== false) {
            fwrite($this->Handle, $output);
        }

        // Notify observers.
        if ($level == LogLevel::EMERGENCY || $level == LogLevel::ALERT) {
            $this->notify();
        }
    }

    /**
     * Notify observers.
     *
     * @param void
     * @return void
     */
    public function notify()
    {
        if (empty($this->Observers)) {
            return;
        }
        foreach ($this->Observers as $observer) {
            $observer->update($this);
        }
    }
}
