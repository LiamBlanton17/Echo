<?php

// Loading models
$Auth = require(__DIR__.'/../models/Auth.model.php');

$router = new EchoAuthRouter($Auth);

return $router;