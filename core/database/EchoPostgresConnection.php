<?php

/**
 * TODO: Add Description
 */

class EchoPostgresConnection extends EchoDatabaseConnection {

    use EchoSQLMethods;
    
    protected array $requiredEnv = ['DBHOST', 'DBPORT', 'DBUSER', 'DBPASS', 'DBDATABASE'];
    
    protected string $host;
    protected string $port;
    protected string $user;
    protected string $pass;
    protected string $database;

    public function configure(array $env){
        $this->host = $env['DBHOST'];
        $this->port = $env['DBPORT'];
        $this->user = $env['DBUSER'];
        $this->pass = $env['DBPASS'];
        $this->database = $env['DBDATABASE'];
    }

    public function start(){
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception("PostgreSQL connection failed: " . $e->getMessage());
        }
    }
}
