<?php

$router = new EchoRouter();

// Loading models
$model = require(__DIR__.'/../models/Admin.model.php');

$router->get('/create', $model('create'));

$router->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Using Admin router.'
    ]);
});

return $router;