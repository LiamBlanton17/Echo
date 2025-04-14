<?php

/**
 * TODO: Add Description
 */

class EchoXCSRFMiddleware extends EchoBaseMiddleware {
    
    use EchoErrors;

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        // Verify EchoSessions are being used
        if(!isset($req->session)){
            $this->error(EchoError::NoEchoSession);
        }
        $session = $req->session;

        // If this is not a new session, validate the xcsrf token
        if(!$session->isnew()){
            $previousToken = $session->get('X-CSRF-Token', '');
            $headerToken = $req->headers['X-CSRF-Token'] ?? '';
            if(!hash_equals($previousToken, $headerToken)) {
                $this->error(EchoError::InvalidXCSRF);
            }
        }

        // Create the new token
        $newToken = bin2hex(random_bytes(32));
        $session->set('X-CSRF-Token', $newToken);
        $res->json(['X-CSRF-Token' => $newToken]);
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

    }

}
