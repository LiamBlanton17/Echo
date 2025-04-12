<?php

require(__DIR__.'/../core/EchoRequire.php');

// Load routers
$userRouter = require(__DIR__.'/routers/User.routers.php');

$app = new EchoApp();

$middleware = [
    'EchoJSONMiddleware',
    'EchoEnvMiddleware',
    'EchoSessionMiddleware',
    'EchoResponseCacheMiddleware',
    'EchoDataCacheMiddleware',
];

$app->use($middleware);

$app->mount('/user', $userRouter);

$app->start();
