<?php

namespace EchoFramework\Application\Middleware;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TODO: Add Description
 */

class EchoEnvMiddleware extends EchoBaseMiddleware {

     /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        $req->env = parse_ini_file(__DIR__.'/../echo.env');
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {}

}