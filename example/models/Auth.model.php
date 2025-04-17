<?php

// Bringing in the main classes
use EchoFramework\Application\Main\{
    EchoRequest,
    EchoResponse,
};

// Bringing in the database connection class
use EchoFramework\Application\Database\Connection\EchoPDOConnection;

// Bringing in AuthModel class
use EchoFramework\Application\Models\EchoAuthModel;

// Creating an AuthModel class
class AuthModel extends EchoAuthModel {

    // Implementiation of a login handler
    public function login(EchoRequest $req, EchoResponse $res) {

        // Use helper verify function
        if(!$this->_verify($req, $res)) return;

        // Login
        $this->_login($req, $this->username);

        // Return success
        $res->status(200)->message('login success');

    }

    public function register(EchoRequest $req, EchoResponse $res) {

        // Return not implemented
        $res->status(501)->message('register not implemented yet');
        return;

        // Use helper verify function
        if(!$this->_verify($req, $res)) return;

    }

    public function delete(EchoRequest $req, EchoResponse $res) {

        // Return not implemented
        $res->status(501)->message('delete not implemented');
        return;

        // Use helper verify function
        if(!$this->_verify($req, $res)) return;
    }

    public function changePassword(EchoRequest $req, EchoResponse $res) {
        
        // Return not implemented
        $res->status(501)->message('changePassword not implemented');
        return;

        // Use helper verify function
        if(!$this->_verify($req, $res)) return;

    }

    // Function called at start of each route that needs a username and password
    protected function _verify(EchoRequest $req, EchoResponse $res): bool {
        // Load username and password from the req, stop if needed
        [$err, $username, $password] = $this->_getInfo($req, $res);
        if(!is_null($err)) return FALSE;

        // Connecting to the database
        $database = $req->database->start();

        // Check if the user exists
        $exists = $this->_userExists($database, $username);
        if(!$exists){
            $res->status(401)->message('username does not exist');
            return FALSE;
        }

        // Validate the password
        $valid = $this->_validatePassword($database, $username, $password);
        if(!$valid){
            $res->status(401)->message('password is invalid');
            return FALSE;
        }

        // Everything is good
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        return TRUE;
    }

    // Helper function to get username and password from the request
    protected function _getInfo(EchoRequest $req, EchoResponse $res): array {
        $username = $req->body->get('username', NULL);
        $password = $req->body->get('password', NULL);
        $err = NULL;
        if(is_null($username)) $err = 'username not provided';
        if(is_null($password)) $err = 'password not provided';
        if(!is_null($err)){
            $res->status(400)->message($err);
            return [$err, NULL, NULL];
        } 
        return [$err, $username, $password];
    }

    // Verify the user exists
    protected function _userExists(EchoPDOConnection $db, string $username): bool {
        $db->query('SELECT username FROM Users WHERE username = :username;');
        $db->bind(':username', $username);
        $db->execute();
        return $db->count() > 0;
    }

    // Validate the password
    protected function _validatePassword(EchoPDOConnection $db, string $username, string $password): bool {
        $db->query('SELECT password FROM Users WHERE username = :username;');
        $db->bind(':username', $username);
        $db->execute();
        $user = $db->single();
        if(is_null($user)) return FALSE;
        return password_verify($password, $user->password);
    }

};

// Returning
return new AuthModel();