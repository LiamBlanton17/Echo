<?php

$model = new class extends EchoModel {

    // Handles a request
    public function getAllUsers(EchoRequest $req, EchoResponse $res) {
        
        $database = $req->database->start();

        $database->query('
            SELECT * FROM Users;
        ');
        $database->execute();
        $rows = $database->all('array');

        $res->status(200)->json([
            'Users' => $rows
        ]);
    }

    // Inserts a user
    public function insertUser(EchoRequest $req, EchoResponse $res) {

        $database = $req->database->start();

        $body = $req->body;

        // id, name
        $database->query('
            INSERT INTO Users
            (name)
            VALUES(:name);
        ');
        $database->bind(':name', $body->get('name', 'DEFAULT'));
        $database->execute();

        $res->status(200)->json([
            'message' => 'Success',
        ]);
    }

};

$model->use(EchoDatabaseMiddleware::use());

return $model;