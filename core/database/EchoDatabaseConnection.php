<?php

/**
 * TODO: Add Description
 */

abstract class EchoDatabaseConnection implements EchoDatabaseConnectionInterface {
    
    use EchoErrors, EchoEnv;

    protected mixed $pdo;
    protected mixed $stmt;

    public function connection(): mixed {
        return $this->pdo;
    }

}