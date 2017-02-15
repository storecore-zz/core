<?php
namespace StoreCore\Database;

/**
 * Abstract MVC Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 *
 * @uses \StoreCore\AbstractModel
 *   This abstract model class extends the core abstract model by adding a
 *   database connection.  Its main purpose therefore is to build MVC models
 *   that require access to a database.
 */
abstract class AbstractModel extends \StoreCore\AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * Add a database connection to the registry if none exists.
     *
     * @param \StoreCore\Registry $registry
     *   Global StoreCore registry.
     *
     * @return void
     *
     * @throws \RuntimeException
     *   A PDO exception is (re)thrown as an SPL runtime exception if
     *   connecting to the default database fails or the proper connection
     *   attributes could not fully be set.  If the database configuration
     *   is set up correctly, the usual cause of a failed connection is a
     *   “Too many connections” timeout, which can only be noticed at runtime.
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        if (false === $registry->has('Connection')) {
            try {
                $dbh = new \StoreCore\Database\Connection();
                if ($dbh === null) {
                    throw new \RuntimeException();
                }

                if ($dbh->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'mysql') {
                    if (version_compare(PHP_VERSION, '5.3.6', '<')) {
                        $dbh->exec('SET NAMES utf8 COLLATE utf8_general_ci');
                    }
                    $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
                }
            } catch (\PDOException $e) {
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
            $registry->set('Connection', $dbh);
        }
        $this->Registry = $registry;
    }
}
