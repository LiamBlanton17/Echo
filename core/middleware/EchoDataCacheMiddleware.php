<?php

/**
 * TODO: Add Description
 */

class EchoDataCacheMiddleware implements EchoMiddleware {
    
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
        
        $req->cache = new EchoDataCache($req);
        $next($req, $res);
    }

}
