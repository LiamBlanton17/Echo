<?php

// Load model
$model = require(__DIR__.'/../models/User.models.php');

// Start a new router
$router = new EchoRouter();
$router->use(EchoDataCacheMiddleware::use());

$router->get('/', $model('getAllUsers'));
$router->post('/', $model('insertUser'));

$router->get('/router', function($req, $res) {
    $res->status(200)->json([
        'message' => 'Router. Does not use DatabaseMiddleware.'
    ]);
});

return $router;