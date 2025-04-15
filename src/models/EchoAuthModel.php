<?php

namespace EchoFramework\Application\Models;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;
use EchoFramework\Application\Authentication\EchoAuth;

/**
 * TODO: Add Description
 */

abstract class EchoAuthModel extends EchoModel {

    use EchoAuth;

    protected string $message = 'Default message';
    protected string $id = '';
    protected string $level = 'all';

    abstract public function changePassword(EchoRequest $req, EchoResponse $res);

    abstract public function delete(EchoRequest $req, EchoResponse $res);

    abstract public function register(EchoRequest $req, EchoResponse $res);

    abstract public function login(EchoRequest $req, EchoResponse $res);

    public function whoiam(EchoRequest $req, EchoResponse $res){
        $isLoggedIn = $this->_isLoggedIn($req);
        $authID = $this->_getAuthID($req);
        $authLevel = $this->_getAuthLevel($req);

        $body = ['message' => 'Not logged in'];
        if($isLoggedIn){
            $body = ['message' => 'Logged in', 'id' => $authID, 'level' => $authLevel];
        }

        $res->status(200)->json($body);
    }

    public function logout(EchoRequest $req, EchoResponse $res){
        $this->_logout($req);

        $res->status(200)->json([
            'message' => 'Logout successful'
        ]);
    }

}
