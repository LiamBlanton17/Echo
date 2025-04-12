<?php

/**
 * TODO: Add Description
 */

class EchoJSONMiddleware implements EchoMiddleware {
    
    /**
     * @param req EchoRequest from the app
     * @param res EchoResponse from the app
     * @param next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {
        $req->loadJSON();
        $next($req, $res);
    }

}
