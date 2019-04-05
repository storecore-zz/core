<?php
namespace StoreCore\Database;

use \StoreCore\FileSystem\Logger as Logger;
use \StoreCore\Registry as Registry;

/**
 * Database Connection
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://www.php.net/manual/en/pdo.construct.php
 * @version   1.0.0
 */
class Connection extends \PDO
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer)
     */
    const VERSION = '1.0.0';

    /**
     * Create a PDO instance for a connection to a database.
     *
     * @param string $dsn
     *   Optional data source name (DSN).  If the DNS is not supplied, it
     *   defaults to the global StoreCore database configuration.  Using
     *   additional DSNs allows for high scalability over multiple databases,
     *   database servers, and other data sources.
     *
     * @param string $username
     *   Optional user name for the DSN string.  If not set, the global
     *   constant `STORECORE_DATABASE_DEFAULT_USERNAME` is used.
     *
     * @param string $password
     *   Optional password for the DSN string.  If the `$username` is not set,
     *   the global constant `STORECORE_DATABASE_DEFAULT_PASSWORD` is used.
     *
     * @return self
     *
     * @throws \PDOException
     *   A catchable \PDOException is (re)thrown if the database connection
     *   fails.  The constructor will try to connect several times, after a
     *   random pause, before finally giving up.
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
        do {
            try {
                parent::__construct($dsn, $username, $password, $options);
                $retry = false;
            } catch (\PDOException $e) {
                // Use a registered or new logger.
                if (!isset($logger)) {
                    $registry = Registry::getInstance();
                    if ($registry->has('Logger')) {
                        $logger = $registry->get('Logger');
                    } else {
                        $logger = new Logger();
                    }
                }

                /* Error: 1049 SQLSTATE: 42000 (ER_BAD_DB_ERROR)
                 * Message: Unknown database '%s'
                 * @see https://dev.mysql.com/doc/refman/5.7/en/error-messages-server.html
                 */
                if ($e->getCode() == 1049) {
                    $logger->alert('Unknown database (fatal error ' . $e->getCode() . '): ' . $e->getMessage());
                    header('HTTP/1.1 502 Bad Gateway', true, 502);
                    exit;
                }

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

                if (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'] > $max_execution_time) {
                    $logger->critical('Database connection failed on error ' . $e->getCode() . ': ' . $e->getMessage());
                    $retry = false;
                    throw $e;
                } else {
                    $logger->error('Database connection error ' . $e->getCode() . ': ' . $e->getMessage());
                    $retry = true;
                }
            }
        } while ($retry === true);
    }
}
