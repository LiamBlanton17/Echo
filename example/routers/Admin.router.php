<?php

use EchoFramework\Application\Routing\EchoRouter;

$router = new EchoRouter();

// Loading models
$Admin = require(__DIR__.'/../models/Admin.model.php');

$router->get('/create', $Admin('create'));

return $router;