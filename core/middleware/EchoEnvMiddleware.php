<?php

/**
 * TODO: Add Description
 */

class EchoEnvMiddleware implements EchoMiddleware {

    /**
     * @param req EchoRequest from the app
     * @param res EchoResponse from the app
     * @param next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {
        $req->env = parse_ini_file(__DIR__.'/../echo.env');
        $next($req, $res);
    }

}