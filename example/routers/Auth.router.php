<?php

// Loading models
$model = require(__DIR__.'/../models/Auth.model.php');

$router = new EchoAuthRouter($model);

$router->get('/', function(EchoRequest $req, EchoResponse $res) {
    $res->status(200)->json([
        'message' => 'Auth router connected.'
    ]);
});

return $router;