<?php

$model = new class extends EchoModel {

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

    // Create table route
    public function create(EchoRequest $req, EchoResponse $res) {
        if(!$this->_auth($req)){
            $res->status(403)->json([
                'message' => 'Admin password or username not valid.'
            ]);
            return;
        }

        $database = $req->database->start();

        $sql = $req->body->get('sql', NULL);

        if(is_null($sql)){
            $res->status(400)->json([
                'message' => 'No SQL provided'
            ]);
            return;
        }
    
        // Bad! SQL Injection. Don't actually do.
        $database->query($sql);
        $database->execute();

        $res->status(200)->json([
            'message' => 'Table created success!'
        ]);

    }

};

$model->use(EchoDatabaseMiddleware::use());

return $model;