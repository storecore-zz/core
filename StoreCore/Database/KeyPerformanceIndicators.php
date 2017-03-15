<?php
namespace StoreCore\Database;

/**
 * Key Performance Indicators (KPIs) Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class KeyPerformanceIndicators extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var array $Dimensions
     *   Custom string parameters for Google Analytics.
     */
    private $Dimensions = array();

    /**
     * @var array $Metrics
     *   Custom integer parameters for Google Analytics.
     */
    private $Metrics = array();

    /**
     * Collect dimensions and metrics.
     *
     * @param \StoreCore\Registry $registry
     * @return self
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        // Dimension 1: StoreCore version
        if (defined('STORECORE_VERSION')) {
            $this->Dimensions[1] = 'StoreCore ' . STORECORE_VERSION;
        }

        // Dimension 2: operating system
        if (function_exists('php_uname')) {
            // Operating system (s), release name (r), version information (v), and machine type (m)
            $os = php_uname('s') . ' ' . php_uname('r') . ' ' . php_uname('v') . ' ' . php_uname('m');
            $os = trim($os);
            $os = preg_replace('/\s+/', ' ', $os);

            // Maximum length of a custom dimension and custom metric is 150 bytes.
            // @see https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#customs
            if (strlen($os) > 150) {
                // Omit version information (v) and machine type (m).
                $os = php_uname('s') . ' ' . php_uname('r');
                $os = trim($os);
                $os = preg_replace('/\s+/', ' ', $os);
                if (strlen($os) > 150) {
                    $os = substr($os, 0, 150);
                }
            }

            $this->Dimensions[2] = $os;
            unset($os);
        }

        // Dimension 3: web server
        if (!empty($_SERVER['SERVER_SOFTWARE'])) {
            $this->Dimensions[3] = $_SERVER['SERVER_SOFTWARE'];
        }

        // Dimension 4: application server
        $this->Dimensions[4] = 'PHP ' . PHP_VERSION . ' ' . PHP_SAPI;

        // Dimension 5: database server
        if (defined('STORECORE_DATABASE_DRIVER')) {
            if (STORECORE_DATABASE_DRIVER == 'mysql') {
                $this->Dimensions[5] = 'MySQL ' . $this->Connection->query('SELECT VERSION()')->fetchColumn();
            }
        }

        // Metric 1: number of active or open stores
        $model = new Stores($this->Registry);
        $this->Metrics[1] = $model->count();

        // Metric 2: number of active users
        $model = new Users($this->Registry);
        $this->Metrics[2] = $model->count();
    }

    /**
     * Get all custom string dimensions.
     *
     * @param void
     * @return array
     */
    public function getDimensions()
    {
        return $this->Dimensions;
    }

    /**
     * Get all custom integer metrics.
     *
     * @param void
     * @return array
     */
    public function getMetrics()
    {
        return $this->Metrics;
    }
}
