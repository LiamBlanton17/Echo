<?php

namespace EchoFramework\Application\Middleware;

use EchoFramework\Application\Other\EchoError;
use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TODO: Add Description
 */

class EchoAuthMiddleware extends EchoBaseMiddleware {

    use EchoErrors;

    /**
     * @var string level of authentication to allow
     */
    protected string $level = 'all';

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        if(!isset($req->session)){
            $this->error(EchoError::NoEchoSession);
        }

        if(!$req->session->get('EchoAuthID')) {
            $res->status(401)->json(['message' => 'Unauthorized'])->output()->finish();
        }
        
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

    }

    /**
     * This function is used by a developer to setup a authentication level
     */
    public function level(string $level = 'all'): self {
        $this->level = $level;
        return $this;
    }

}
