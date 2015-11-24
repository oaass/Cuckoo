<?php

$modulesPath = APP_PATH . '/modules/';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($modulesPath),
    RecursiveIteratorIterator::SELF_FIRST
);

$modules = [];

foreach ($iterator as $file) {
    if ($file->getFilename() === 'Module.php') {
        $path = $file->getPath();
        $module = str_replace(APP_PATH . '/modules/', '', $path);
        $namespace = str_replace('/', '\\', $module);
        $key = strtolower(explode('/', $module)[0]);
        $modules[$key] = [
            'className' => "Cuckoo\Modules\\{$namespace}\\Module",
            'path' => "{$path}/Module.php"
        ];
    }
}

return $modules;