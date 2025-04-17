<?php

use EchoFramework\Application\Database\Management\UsersTable;
use EchoFramework\Application\Main\{
    EchoRequest,
    EchoResponse,
};

use EchoFramework\Application\Models\EchoModel;
use EchoFramework\Application\Views\UserView;

class UserModal extends EchoModel {

    // Custom Auth method
    private function _auth(EchoRequest $req) {
        $credentials = $req->body->get('credentials', NULL);
        $env = $req->env;

        if(is_null($credentials)) return FALSE;

        if(!isset($credentials['username'])) return FALSE;
        if($credentials['username'] !== $env['ADMIN_USERNAME']) return FALSE;

        if(!isset($credentials['password'])) return FALSE;
        if($credentials['password'] !== $env['ADMIN_PASSWORD']) return FALSE;

        return TRUE;
    }

    // Create user
    public function create(EchoRequest $req, EchoResponse $res) {
        if(!$this->_auth($req)){
            $res->status(403)->json([
                'message' => 'Admin password or username not valid.'
            ]);
            return;
        }

        $database = $req->database->start();
        $body = $req->body;

        $info = $body->get('info');
        $username = $info['username'] ?? NULL;
        $firstname = $info['firstname'] ?? NULL;
        $lastname = $info['lastname'] ?? NULL;
        $password = $info['password'] ?? NULL;

        if(is_null($username) || is_null($firstname) || is_null($lastname) || is_null($password)){
            $res->status(400)->json([
                'message' => 'Invalid JSON input.'
            ]);
            return;
        }  

        $database->query('
            INSERT INTO users
            (username, firstname, lastname, password)
            VALUES(:username, :firstname, :lastname, :password);
        ');
        $database->bind(':username', $username);
        $database->bind(':firstname', $firstname);
        $database->bind(':lastname', $lastname);
        $database->bind(':password', password_hash($password, PASSWORD_DEFAULT));
        $database->execute();

        $res->status(200)->json([
            'message' => 'User created success!'
        ]);
    }

    // Get all users
    public function all(EchoRequest $req, EchoResponse $res) {

        $database = $req->database->start();

        $database->query('
            SELECT * FROM users;
        ');
        $database->execute();
        $users = $database->all('array');

        $res->status(200)->json([
            'users'=> $users
        ]);

    }

};

$UserModal = new UserModal();

return $UserModal;