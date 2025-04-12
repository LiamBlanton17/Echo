<?php

/**
 * TODO: Add Description
 */

abstract class EchoDatabaseConnection implements EchoDatabaseConnectionInterface {
    
    use EchoErrors, EchoEnv;

    protected mixed $connection;

    public function connection(): mixed {
        return $this->connection;
    }

}