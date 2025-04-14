<?php

require(__DIR__.'/../core/EchoRequire.php');

$app = new EchoApp();

// Loading routers
$adminRouter = require(__DIR__.'/routers/Admin.router.php');
$userRouter = require(__DIR__.'/routers/User.router.php');

$app->use(EchoJSONMiddleware::use());
$app->use(EchoEnvMiddleware::use());
$app->use(EchoSessionMiddleware::use());

$app->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Connected to an Echo Framework.'
    ]);
});

$app->mount('/admin', $adminRouter);
$app->mount('/user', $userRouter);

$app->start();
