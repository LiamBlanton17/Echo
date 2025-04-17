<?php

use EchoFramework\Application\Middleware\EchoAuthMiddleware;
use EchoFramework\Application\Routing\EchoRouter;

// Loading models
$UserModel = require(__DIR__.'/../models/User.model.php');

$UserRouter = new EchoRouter();

$UserRouter->use(EchoAuthMiddleware::use());

$UserRouter->get('/all', $UserModel('all'));
$UserRouter->post('/create', $UserModel('create'));

return $UserRouter;