<?php

// Using autoloader
require __DIR__.'/../vendor/autoload.php';

// Bringing in Echo main classes
use EchoFramework\Application\Main\{
    EchoApp, 
    EchoRequest,
    EchoResponse
};

// Bringing in Echo middleware classes
use EchoFramework\Application\Middleware\{
    EchoJSONMiddleware,
    EchoEnvMiddleware,
    EchoSessionMiddleware,
    EchoBasicSecurityMiddleware
};

// Bringing in the Routers
$AuthRouter = require __DIR__.'/routers/Auth.router.php';

// Building a new Echo App
$app = new EchoApp();

// Using middleware
$app->use(EchoJSONMiddleware::use());
$app->use(EchoEnvMiddleware::use());
$app->use(EchoSessionMiddleware::use());
$app->use(EchoBasicSecurityMiddleware::use());

// Mounting the Auth router
$app->mount('/auth', $AuthRouter);

// Setting up a new route
$app->get('/', function(EchoRequest $req, EchoResponse $res) {

    // Returning a simple connection message
    $res->status(200)->message('Connected to an EchoFramework');

});

// Building the app, calling it EchoApp, and placing it in the given directory
$app->build('/mnt/c/Users/Liamb/SideProjects/Echo/example/app', 'EchoApp');