<?php

use EchoFramework\Application\Main\{
    EchoRequest,
    EchoResponse,
};

use EchoFramework\Application\Models\EchoAuthModel;

class AuthModel extends EchoAuthModel {

    public function login(EchoRequest $req, EchoResponse $res) {

        $body = $req->body;
        $username = $body->get('username', NULL);
        $password = $body->get('password', NULL);

        $res->status(201)->json([
            'message' => 'login attempt'
        ]);

    }

    public function register(EchoRequest $req, EchoResponse $res) {

        $body = $req->body;
        $username = $body->get('username', NULL);
        $password = $body->get('password', NULL);
        $firstname = $body->get('firstname', NULL);
        $username = $body->get('lastname', NULL);
        $lastname = $body->get('password', NULL);
        $key = $body->get('key', NULL);

    }

    public function changePassword(EchoRequest $req, EchoResponse $res) {

        $body = $req->body;
        $username = $body->get('username', NULL);
        $old = $body->get('old_password', NULL);
        $new = $body->get('new_password', NULL);

    }

    public function delete(EchoRequest $req, EchoResponse $res) {

        $body = $req->body;
        $username = $body->get('username', NULL);
        $password = $body->get('password', NULL);

    }

};

$AuthModel = new AuthModel();

return $AuthModel;