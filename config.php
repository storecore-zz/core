<?php
/**
 * StoreCore Global Configuration File
 */

/* Core */
define('STORECORE_KILL_SWITCH', false);
define('STORECORE_MAINTENANCE_MODE', false);
define('STORECORE_NULL_LOGGER', false);

/* Database */
define('STORECORE_DATABASE_DRIVER',           'mysql');
define('STORECORE_DATABASE_DEFAULT_HOST',     'localhost');
define('STORECORE_DATABASE_DEFAULT_DATABASE', 'test');
define('STORECORE_DATABASE_DEFAULT_USERNAME', 'root');
define('STORECORE_DATABASE_DEFAULT_PASSWORD', '');

/* File System */
// define('STORECORE_FILESYSTEM_CACHE_DIR', '');
// define('STORECORE_FILESYSTEM_CACHE_DATA_DIR', '');
// define('STORECORE_FILESYSTEM_CACHE_OBJECTS_DIR', '');
// define('STORECORE_FILESYSTEM_CACHE_PAGES_DIR', '');
// define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', '');
// define('STORECORE_FILESYSTEM_LOGS_DIR', '');
define('STORECORE_FILESYSTEM_LOGS_FILENAME_FORMAT', 'YmdH');

/* Business Intelligence (BI) */
define('STORECORE_BI', false);
define('STORECORE_BI_GOOGLE_ANALYTICS', false);
// define('STORECORE_BI_GOOGLE_ANALYTICS_TRACKING_ID', 'UA-XXXX-Y');
