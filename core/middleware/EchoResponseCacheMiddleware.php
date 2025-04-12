<?php

/**
 * TODO: Add Description
 */

class EchoResponseCacheMiddleware implements EchoMiddleware {
    
    use EchoErrors, EchoEnv;

    protected array $requiredEnv = ['CACHEPATH'];

    /**
     * @param req EchoRequest from the app
     * @param res EchoResponse from the app
     * @param next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {

        // Verify correct env exist
        if(!$this->verifyEnv($req->env)){
            $this->error(EchoErrorType::InvalidEnv);
        }

        // Verify EchoSessions are being used
        if(!isset($req->session)){
            $this->error(EchoErrorType::NoEchoSession);
        }

        // Lookup in cache - if there is a policy
        $hasPolicy = !is_null($req->cachingPolicy);
        if($hasPolicy){
            $result = EchoResponseCache::get($req);
            if(!is_null($result)){
                /**
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

        // If not found, continue
        $next($req, $res);

        // Cache the result - if there is a policy
        if($hasPolicy){
            EchoResponseCache::put($req, $res);
        }
    }

}