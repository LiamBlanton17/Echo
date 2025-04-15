<?php

/**
 * TODO: Add Description
 */

class EchoDatabaseMiddleware extends EchoBaseMiddleware {
    
    use EchoErrors;

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        if(!isset($req->env)){
            $this->error(Echoerror::InvalidEnv);
        }
        $env = $req->env;
        $req->database = EchoDatabaseFactory::create($env);
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {}

}
