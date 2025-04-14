<?php

require(__DIR__.'/../core/EchoRequire.php');

// Load routers
$userRouter = require(__DIR__.'/routers/User.routers.php');

$app = new EchoApp();

$app->use(EchoJSONMiddleware::use());
$app->use(EchoEnvMiddleware::use());
$app->use(EchoSessionMiddleware::use());
$app->use(EchoResponseCacheMiddleware::use());

$app->mount('/user', $userRouter);

$app->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Successfully connectioned!'
    ]);
});

$app->start();
