<?php
/**
 * StoreCore Framework Bootloader
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GPLv3
 * @version   0.1.0
 */

 // Load, instantiate, and register the StoreCore autoloader
require_once __DIR__ . 'Autoloader.php';
$loader = new \StoreCore\Autoloader();
$loader->register();

// Load core classes
require_once __DIR__ . 'Registry.php';
require_once __DIR__ . 'AbstractModel.php';
require_once __DIR__ . 'AbstractController.php';
