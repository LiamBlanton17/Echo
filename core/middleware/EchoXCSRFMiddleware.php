<?php

/**
 * TODO: Add Description
 */

class EchoXCSRFMiddleware implements EchoMiddleware {
    
    use EchoErrors;

    /**
     * @param req EchoRequest from the app
     * @param res EchoResponse from the app
     * @param next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {

        // Verify EchoSessions are being used
        if(!isset($req->session)){
            $this->error(EchoErrorType::NoEchoSession);
        }
        $session = $req->session;

        // If this is not a new session, validate the xcsrf token
        if(!$session->isnew()){
            $previousToken = $session->get('X-CSRF-Token', '');
            $headerToken = $req->headers['X-CSRF-Token'] ?? '';
            if(!hash_equals($previousToken, $headerToken)) {
                $this->error(EchoErrorType::InvalidXCSRF);
            }
        }

        // Create the new token
        $newToken = bin2hex(random_bytes(32));
        $session->set('X-CSRF-Token', $newToken);
        $res->json(['X-CSRF-Token' => $newToken]);
        $next($req, $res);
    }

}
