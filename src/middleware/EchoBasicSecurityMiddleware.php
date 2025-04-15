<?php

/**
 * TODO: Add Description
 */

class EchoBasicSecurityMiddleware extends EchoBaseMiddleware {

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {

    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

        // Adding after so the user can't modify or remove
        $res->addHeader('X-XSS-Protection', '1; mode=block');
        $res->addHeader('X-Frame-Options', 'SAMEORIGIN');
        $res->addHeader('X-Content-Type-Options', 'nosniff');

    }

}