<?php

// Using autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bringing in Echo main classes
use EchoFramework\Application\Main\{
    EchoApp,
};

// Loading in routers
array_map(fn($fn) => require($fn), glob(__DIR__.'/routers/*.php'));

// Booting the application and starting it
EchoApp::boot('/mnt/c/Users/Liamb/SideProjects/Echo/example/app', 'EchoApp')->start();