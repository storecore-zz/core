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
// define('StoreCore\\FileSystem\\CACHE_DIR', '');
// define('StoreCore\\FileSystem\\LIBRARY_ROOT_DIR', '');
// define('StoreCore\\FileSystem\\LOGS_DIR', '');
