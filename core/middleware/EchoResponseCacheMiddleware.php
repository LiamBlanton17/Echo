<?php

/**
 * TODO: Add Description
 */

class EchoResponseCacheMiddleware extends EchoBaseMiddleware {
    
    use EchoErrors, EchoEnv;

    protected array $requiredEnv = ['CACHEPATH'];

    protected bool $hasPolicy;

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

        // Lookup in cache - if there is a policy
        $this->hasPolicy = !is_null($req->cachingPolicy);
        if($this->hasPolicy){
            $result = EchoResponseCache::get($req); 
            if(!is_null($result)){
                /**
                 * Perhaps use the fact that EchoResponse::get() is a singleton?
                 * 
                 * I think this is a really bad way of doing things
                 * But you cannot write $res = $result; return;
                 * That does not transfer the $res back to the EchoApp scope.
                 * Hopefully find a cleaner way of doing things.
                 * I wanted to call output() from only 1 location.
                 */
                $result->output();
                die(); 
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
        // Cache the result - if there is a policy
        if($this->hasPolicy){
            EchoResponseCache::put($req, $res);
        }
    }

}