<?php

// Loading models
$User = require(__DIR__.'/../models/User.model.php');

$router = new EchoRouter();

$router->get('/all', $User('all'));
$router->post('/create', $User('create'));

return $router;