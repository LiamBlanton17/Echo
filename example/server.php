<?php

require __DIR__ . '/../vendor/autoload.php';

use EchoFramework\Application\Main\{
    EchoApp,
};

array_map(fn($fn) => require($fn), glob(__DIR__.'/routers/*.php'));

$app = EchoApp::boot('/mnt/c/Users/Liamb/SideProjects/Echo/example/app', 'app');

$app->start();