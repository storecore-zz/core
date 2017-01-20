<?php
namespace StoreCore\Database;

use \Psr\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Psr\Log\LoggerInterface as LoggerInterface;

/**
 * Database Connection
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class Connection extends \PDO implements LoggerAwareInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /** @var \Psr\Log\LoggerInterface|null $Logger */
    protected $Logger;

    /**
     * @param string $dsn
     *   Optional data source name (DSN).  If the DNS is not supplied, it
     *   defaults to the global StoreCore database configuration.  Using
     *   additional DSNs allows for high scalability over multiple databases,
     *   database servers, and other data sources.
     *
     * @param string $username
     *
     * @param string $password
     *
     * @return self
     *
     * @throws \PDOException
     */
    public function __construct($dsn = null, $username = null, $password = null)
    {
        if ($dsn === null) {
            $dsn = STORECORE_DATABASE_DRIVER
                . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
                . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
                . ';charset=utf8';
        }

        if ($username === null) {
            $username = STORECORE_DATABASE_DEFAULT_USERNAME;
            $password = STORECORE_DATABASE_DEFAULT_PASSWORD;
        }

        // Force lower case column names and exceptions on errors.
        $options = array(
            \PDO::ATTR_CASE => \PDO::CASE_LOWER,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        );

        // Try to connect.
        $retry = true;
        while ($retry === true) {
            try {
                parent::__construct($dsn, $username, $password, $options);
                $retry = false;
            } catch (\PDOException $e) {
                // Retry to connect in 0.5 to 3.5 seconds.
                usleep(mt_rand(500000, 3500000));

                // Execute for the PHP maximum execution time minus 4 seconds.
                if (!isset($max_execution_time)) {
                    $max_execution_time = ini_get('max_execution_time');
                    if ($max_execution_time === false || empty($max_execution_time)) {
                        $max_execution_time = 26;
                    } else {
                        $max_execution_time = $max_execution_time - 4;
                    }
                }

                // Add a registered logger.
                if (!isset($this->Logger)) {
                    $registry = \StoreCore\Registry::getInstance();
                    if (false === $registry->has('Logger')) {
                        $registry->set('Logger', new \StoreCore\FileSystem\Logger());
                    }
                    $this->setLogger($registry->get('Logger'));
                }

                if (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'] > $max_execution_time) {
                    $logger->critical('Database connection failed: ' . trim($e->getMessage()));
                    $retry = false;
                    if (!headers_sent()) {
                        header('HTTP/1.1 503 Service Unavailable', true);
                        header('Retry-After: 60');
                    }
                    throw $e;
                } else {
                    $logger->error('Database connection error ' . $e->getCode() . ': ' . trim($e->getMessage()));
                    $retry = true;
                }
            }
        }

        // Options for MySQL only
        if ($this->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'mysql') {
            if (version_compare(PHP_VERSION, '5.3.6', '<')) {
                $this->exec('SET NAMES utf8 COLLATE utf8_general_ci');
            }
            $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }
    }

    /**
     * Add a logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->Logger = $logger;
    }
}
