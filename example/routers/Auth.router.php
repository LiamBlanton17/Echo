<?php

// Bringing in the main classes
use EchoFramework\Application\Main\{
    EchoRequest,
    EchoResponse
};

// Bringing in Echo middleware classes
use EchoFramework\Application\Middleware\{
    EchoBasicRateLimiterMiddleware,
    EchoDatabaseMiddleware
};

// Bringing in AuthRouter class
use EchoFramework\Application\Authentication\EchoAuthRouter;

// Loading models
$AuthModel = require __DIR__.'/../models/Auth.model.php';

// Building a new AuthRouter, using the AuthModel
$AuthRouter = new EchoAuthRouter($AuthModel);

// Add database middleware
$AuthRouter->use(EchoBasicRateLimiterMiddleware::use()->rate(1, 2));
$AuthRouter->use(EchoDatabaseMiddleware::use());

// Setting a confirmation route
$AuthRouter->get('/', function(EchoRequest $req, EchoResponse $res) {

    // Confirmation response
    $res->status(200)->json([
        'message' => 'Connected to the Auth router'
    ]);

});

// Returning the router (export)
return $AuthRouter;