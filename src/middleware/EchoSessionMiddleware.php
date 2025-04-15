<?php

namespace EchoFramework\Application\Middleware;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;
use EchoFramework\Application\Other\EchoSession;

/**
 * TODO: Add Description
 */

class EchoSessionMiddleware extends EchoBaseMiddleware {
    
    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        $session = new EchoSession();
        $session->start($req);
        $req->session = $session;
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {}

}
