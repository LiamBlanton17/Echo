<?php

require __DIR__ . '/../vendor/autoload.php';

use EchoFramework\Application\Main\{
    EchoApp,
    EchoRequest,
    EchoResponse,
};

use EchoFramework\Application\Middleware\{
    EchoJSONMiddleware,
    EchoEnvMiddleware,
    EchoSessionMiddleware,
    EchoDatabaseMiddleware,
};

$app = new EchoApp();

// Loading routers
$adminRouter = require(__DIR__.'/routers/Admin.router.php');
$userRouter = require(__DIR__.'/routers/User.router.php');
$authRouter = require(__DIR__.'/routers/Auth.router.php');

$app->use(EchoJSONMiddleware::use());
$app->use(EchoEnvMiddleware::use());
$app->use(EchoSessionMiddleware::use());
$app->use(EchoDatabaseMiddleware::use());

$app->mount('/admin', $adminRouter);
$app->mount('/user', $userRouter);
$app->mount('/auth', $authRouter);

$app->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Pre boot route'
    ]);
});

$app->patch('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Pre patch route'
    ]);
});

$app->build('/mnt/c/Users/Liamb/SideProjects/Echo/example/app', 'app');
