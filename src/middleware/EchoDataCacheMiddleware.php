<?php

/**
 * TODO: Add Description
 */

class EchoDataCacheMiddleware extends EchoBaseMiddleware {
    
    use EchoErrors, EchoEnv;

    protected array $requiredEnv = ['CACHEPATH'];

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        // Verify correct env exist
        if(!$this->verifyEnv($req->env)){
            $this->error(EchoError::InvalidEnv);
        }

        // Verify EchoSessions are being used
        if(!isset($req->session)){
            $this->error(EchoError::NoEchoSession);
        }
        
        $req->cache = new EchoDataCache($req);
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
