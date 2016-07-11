<?php
namespace StoreCore\Database;

/**
 * Database Connection
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Database
 * @version   0.1.0
 */
class Connection extends \PDO
{
    const VERSION = '0.1.0';

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
     * @return void
     */
    public function __construct($dsn = null, $username = null, $password = null)
    {
        if ($dsn == null) {
            $dsn = \StoreCore\Database\DRIVER
                . ':dbname=' . \StoreCore\Database\DEFAULT_DATABASE
                . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
                . ';charset=utf8';
        }

        if ($username == null) {
            $username = \StoreCore\Database\DEFAULT_USERNAME;
            $password = \StoreCore\Database\DEFAULT_PASSWORD;
        }

        // Force lower case column names and exceptions on errors.
        $options = array(
            \PDO::ATTR_CASE => \PDO::CASE_LOWER,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        );

        try {
            parent::__construct($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->critical('Database connection failed: ' . trim($e->getMessage()));
            if (!headers_sent()) {
                header('HTTP/1.1 503 Service Unavailable', true);
                header('Retry-After: 60');
            }
            exit;
        }

        if (version_compare(PHP_VERSION, '5.3.6', '<')) {
            $this->exec('SET NAMES utf8 COLLATE utf8_general_ci');
        }
    }
}
