<?php

$router = new EchoRouter();

// Loading models
$model = require(__DIR__.'/../models/User.model.php');

$router->get('/all', $model('all'));
$router->get('/create', $model('create'));

$router->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Using User router.'
    ]);
});

return $router;