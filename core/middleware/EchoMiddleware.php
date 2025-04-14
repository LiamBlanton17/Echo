<?php

/**
 * TODO: Add Description
 */

interface EchoMiddleware {

    /**
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @param callable $next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next);

    /**
     * @return self
     */
    public static function use(): self;

}
