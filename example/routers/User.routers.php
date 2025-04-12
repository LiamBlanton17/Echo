<?php

// Load model
$model = require(__DIR__.'/../models/User.models.php');

$router = new EchoRouter();

$router->get('/', $model('getAllUsers'));

return $router;