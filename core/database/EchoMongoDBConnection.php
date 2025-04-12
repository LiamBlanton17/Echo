<?php

/**
 * TODO: Add Description
 */

use MongoDB\Client;

class EchoMongoConnection extends EchoDatabaseConnection {
 
    use EchoNoSQLMethods;
    protected array $requiredEnv = ['DBHOST', 'DBPORT', 'DBDATABASE'];
     
    protected string $host;
    protected string $port;
    protected string $database;
 
    public function configure(array $env){

        // Echo does not support MongoDB by default
        if (!class_exists(Client::class)) {
            $this->error(EchoErrorType::MissingMongoDBResource);
        }

        $this->host = $env['DBHOST'];
        $this->port = $env['DBPORT'];
        $this->database = $env['DBDATABASE'];
    }
 
    public function start(){
        $uri = "mongodb://{$this->host}:{$this->port}";
        try {
            $client = new Client($uri);
            $this->connection = $client->selectDatabase($this->database);
        } catch (Exception $e) {
            throw new Exception("MongoDB connection failed: " . $e->getMessage());
        }
    }
}
 