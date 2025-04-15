<?php

use EchoFramework\Application\Authentication\EchoAuthRouter;

// Loading models
$Auth = require(__DIR__.'/../models/Auth.model.php');

$router = new EchoAuthRouter($Auth);

return $router;