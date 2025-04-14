<?php

/**
 * TODO: Add Description
 * 
 * @todo Does not really work. Caching GET routes messes it up
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

        // If this is not a new session, validate the xcsrf token from the header
        // Must be a HTTP method that should be validated
        if(!$session->isnew() && in_array($req->method, ['POST', 'PUT', 'PATCH', 'DELETE'])){
            $previousToken = $session->get('X-CSRF-Token', 'notoken');
            $headerToken = $req->headers['X-CSRF-Token'] ?? 'noheader';
            if(!hash_equals($previousToken, $headerToken)) {
                $this->error(EchoError::InvalidXCSRF);
            }
        }
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

        // Update token on GET request
        if($req->method === 'GET'){
            // Create the new token
            $newToken = bin2hex(random_bytes(32));

            // Set the new token in the PHP session
            $req->session->set('X-CSRF-Token', $newToken);

            // Send it back as a cookie
            $res->cookie('X-CSRF-Token', $newToken, [
                'secure' => FALSE, 
                'httponly' => FALSE, 
                'samesite' => 'Strict',
                'path' => '/',  
                'expires' => time() + 3600 
            ]);

        }
    }

}
