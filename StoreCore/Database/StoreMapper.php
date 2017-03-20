<?php
namespace StoreCore\Database;

/**
 * Store Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class StoreMapper extends AbstractDataAccessObject
{
    /**
     * @var string PRIMARY_KEY DAO database table primary key.
     * @var string TABLE_NAME  DAO database table name.
     * @var string VERSION     Semantic Version (SemVer).
     */
    const PRIMARY_KEY = 'store_id';
    const TABLE_NAME = 'sc_stores';
    const VERSION = '0.1.0';

    /**
     * Find a store that matches a request.
     *
     * @param string|null $host_name
     *   Optional host name of the store.
     *
     * @return \StoreCore\Store|null
     *   Returns a store model object or null if no store was found.  This
     *   method MAY execute a permanent redirect if the requested store is
     *   located elsewhere; StoreCore supports redirects to a specific URL,
     *   to a different host name, and to an IP address (in that order).
     *
     * @uses \StoreCore\Request::getHostName()
     *   If the `$host_name` parameter is omitted, the default host name
     *   in the current HTTP request is used to match the request to a store.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$host_name` parameter is
     *   not a string or an empty string.
     */
    public function find($host_name = null)
    {
        if ($host_name === null) {
            $host_name = $this->Request->getHostName();
        } elseif (!is_string($host_name) || empty($host_name) ) {
            throw new \InvalidArgumentException();
        } else {
            $host_name = mb_strtolower($host_name, 'UTF-8');
        }

        $stmt = $this->Connection->prepare('
               SELECT h.store_id, h.redirect_flag, h.redirect_to,
                      s.enabled_flag, s.store_name
                 FROM sc_store_hosts h
            LEFT JOIN sc_stores s ON h.store_id = s.store_id
                WHERE h.host_name = :host_name
        ');
        $stmt->bindValue(':host_name', $host_name, \PDO::PARAM_STR);
        $stmt->execute();
        $host = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Find possible redirect candidates if no matching host is found.
        if ($host === false || empty($host)) {
            $stmt = $this->Connection->prepare('
                   SELECT h.host_name, s.ssl_mode
                     FROM sc_store_hosts h
                LEFT JOIN sc_stores s ON h.store_id = s.store_id
                    WHERE h.redirect_flag = 0
                 ORDER BY s.enabled_flag DESC
            ');
            $stmt->execute();
            $hosts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            // Return null on 0 active host names or redirect on 1 host name.
            if ($hosts === false || empty($hosts)) {
                return null;
            } elseif (count($hosts) === 1) {
                if ($hosts['ssl_mode'] === 0) {
                    $location .= 'http://' . $hosts['host_name'] . '/';
                } else {
                    $location .= 'https://' . $hosts['host_name'] . '/';
                }
                $response = new \StoreCore\Response($this->Registry);
                $response->redirect($location, 301);
            }

            // Find a similar host name.
            $smallest_levenshtein_distance = 255;
            foreach ($hosts as $candidate) {
                $levenshtein_distance = levenshtein($host_name, $candidate['host_name']);
                if ($levenshtein_distance < $smallest_levenshtein_distance) {
                    $location = ($candidate['ssl_mode'] === 0) ? 'http://' : 'https://';
                    $location .= $candidate['host_name'] . '/';
                    $smallest_levenshtein_distance = $levenshtein_distance;
                }
            }
            $response = new \StoreCore\Response($this->Registry);
            $response->redirect($location, 301);
        }

        // Return the store for a known host name.
        if ($host['redirect_flag'] === 0) {
            return $this->getStoreObject($host);
        }

        // Execute a permanent redirect to a fixed location or to a matching
        // host name or host IP address that is NOT used for redirection.
        if ($host['redirect_to'] !== null) {
            $location = $host['redirect_to'];
        } else {
            $stmt = $this->Connection->prepare('
                   SELECT h.host_ip, h.host_name, s.ssl_mode
                     FROM sc_store_hosts h
                LEFT JOIN sc_stores s ON h.store_id = s.store_id
                    WHERE h.store_id = :store_id
                      AND redirect_flag = 0
            ');
            $stmt->bindValue(':store_id', $host['store_id'], \PDO::PARAM_INT);
            $stmt->execute();
            $host = $stmt->fetch();
            $stmt->closeCursor();
            if ($host === false || empty($host)) {
                return null;
            } else {
                if ($host['host_name'] !== null) {
                    $location = $host['host_name'];
                } elseif ($host['host_ip'] !== null) {
                    $location = $host['host_ip'];
                } else {
                    return null;
                }

                if ($host['ssl_mode'] === 0) {
                    $location = 'http://' . $location . '/';
                } else {
                    $location = 'https://' . $location . '/';
                }
            }
        }

        $response = new \StoreCore\Response($this->Registry);
        $response->redirect($location, 301);
    }

    /**
     * Fetch a store by its store ID.
     *
     * @param \StoreCore\Types\StoreID $store_id
     *   Data object for the store identifier.
     *
     * @return \StoreCore\Store|null
     *   Returns a store model object if the store exists or null if it does
     *   not exists.
     */
    public function getStore(\StoreCore\Types\StoreID $store_id)
    {
        $store_id = (string)$store_id;
        $store_data = $this->read($store_id);
        if ($store_data !== false) {
            $store_data = $store_data[0];
            return $this->getStoreObject($store_data);
        } else {
            return null;
        }
    }

    /**
     * Map a store’s data to a store model object.
     *
     * @param array $store_data
     * @return \StoreCore\Store
     */
    private function getStoreObject(array $store_data)
    {
        $store_id = new \StoreCore\Types\StoreID($store_data['store_id']);

        $store = new \StoreCore\Store($this->Registry);
        $store->setStoreID($store_id);
        $store->setStoreName($store_data['store_name']);
        if ($store_data['enabled_flag'] === 1) {
            $store->open();
        }

        $model = new \StoreCore\Database\Languages($this->Registry);
        $store->setStoreLanguages($model->getStoreLanguages($store_id));

        $model = new \StoreCore\Database\Currencies($this->Registry);
        $store->setStoreCurrencies($model->getStoreCurrencies($store_id));

        return $store;
    }
}
