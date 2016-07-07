<?php
/**
 * StoreCore Global Configuration File
 */

/* Core */
define('STORECORE_KILL_SWITCH', false);
define('STORECORE_MAINTENANCE_MODE', false);
define('STORECORE_NULL_LOGGER', false);
define('STORECORE_STATISTICS', false);

/* Database */
define('StoreCore\\Database\\DRIVER',           'mysql');
define('StoreCore\\Database\\DEFAULT_HOST',     'localhost');
define('StoreCore\\Database\\DEFAULT_DATABASE', 'test');
define('StoreCore\\Database\\DEFAULT_USERNAME', 'root');
define('StoreCore\\Database\\DEFAULT_PASSWORD', '');

/* File System */
// define('STORECORE_FILESYSTEM_CACHE_DIR', '');
// define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', '');
// define('STORECORE_FILESYSTEM_LOGS_DIR', '');
define('STORECORE_FILESYSTEM_LOGS_FILENAME_FORMAT', 'YmdH');
