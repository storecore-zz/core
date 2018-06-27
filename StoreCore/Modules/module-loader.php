<?php
$namespaces = array();
foreach (new \DirectoryIterator(__DIR__) as $directory) {
    if ($directory->isDir() && !$directory->isDot()) {
        $namespaces[$directory->getFilename()] = $directory->getPathname() . DIRECTORY_SEPARATOR;
        foreach (new \DirectoryIterator($directory->getPathname()) as $subdirectory) {
            if ($subdirectory->isDir() && !$subdirectory->isDot()) {
                $namespaces[$directory->getFilename() . '\\'  . $subdirectory->getFilename()] = $subdirectory->getPathname() . DIRECTORY_SEPARATOR;
            }
        }
    }
}

if (!isset($loader)) {
    $loader = new \StoreCore\Autoloader();
    $loader->register();
}

foreach ($namespaces as $namespace => $path) {
    $loader->addNameSpace($namespace, $path);
}
