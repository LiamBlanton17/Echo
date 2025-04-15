<?php

namespace EchoFramework\Application\Database;

use EchoFramework\Application\Other\EchoError;
use \PDO, \PDOException, \Exception;

/**
 * TODO: Add Description
 */

class EchoSQLiteConnection extends EchoPDOConnection {

    protected string $file;

    public function __construct(array $env) {
        if(!isset($env['DBFILE'])){
            $this->error(EchoError::InvalidEnv);
        }
        $this->file = $env['DBFILE'];
    }

    public function start(): self {
        $dsn = "sqlite:{$this->file}";
        try {
            $this->pdo = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception("SQLite connection failed: " . $e->getMessage());
        }
        return $this;
    }

}
