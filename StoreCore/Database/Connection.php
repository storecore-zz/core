<?php
namespace StoreCore\Database;

/**
 * Database Connection
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore\Database
 * @version   0.0.1
 */
class Connection extends \PDO
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /**
     * @param string $dsn
     *     Optional data source name (DSN).  If the DNS is not supplied, it
     *     defaults to the global StoreCore database configuration.  Using
     *     additional DSNs allows for high scalability over multiple databases,
     *     database servers, and other data sources.
     *
     * @param string $username
     *
     * @param string $password
     */
    public function __construct($dsn = null, $username = null, $password = null)
    {
        if ($dsn == null) {
            $dsn = STORECORE_DATABASE_DRIVER
                . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
                . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
                . ';charset=utf8';
        }
  
        if ($username == null) {
            $username = STORECORE_DATABASE_USERNAME;
            $password = STORECORE_DATABASE_PASSWORD;
        }

        try {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            if (version_compare(PHP_VERSION, '5.3.6', '<')) {
                $this->exec('SET NAMES utf8');
            }
        } catch (\PDOException $e) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->error('Database connection failed: ' . trim($e->getMessage()));

            // Reconnect after a few seconds to balance heavy loads
            $seconds = mt_rand(2, 5);
            $logger->notice('Reconnecting in ' . $seconds . ' seconds.');
            sleep($seconds);
            try {
                parent::__construct($dsn, $username, $password);
                $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                if (version_compare(PHP_VERSION, '5.3.6', '<')) {
                    $this->exec('SET NAMES utf8');
                }
            } catch (\PDOException $e) {
                $logger->critical('Service unavailable: ' . trim($e->getMessage()));
                if (!headers_sent()) {
                    header('HTTP/1.1 503 Service Unavailable', true, 503);
                    header('Retry-After: 60');
                }
                exit;
            }
        }
    }
}
