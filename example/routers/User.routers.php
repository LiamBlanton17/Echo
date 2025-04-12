<?php

// Load model
$model = require(__DIR__.'/../models/User.models.php');

$router = new EchoRouter();

$router->get('/', $model('getAllUsers', ['message' => 'Using a model params']));

return $router;