<?php

/**
 * TODO: Add Description
 */

abstract class EchoBaseMiddleware implements EchoMiddleware {

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    abstract protected function _before(EchoRequest $req, EchoResponse $res);

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    abstract protected function _after(EchoRequest $req, EchoResponse $res);

    /**
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @param callable $next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {
        $this->_before($req, $res);
        $next($req, $res);
        $this->_after($req, $res);
    }

    /**
     * @return static
     */
    public static function use(): self {
        return new static();
    }


    /**
     * Hiding the constructor to force use()
     */
    protected function __construct() {}

}