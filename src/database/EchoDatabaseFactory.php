<?php

/**
 * TODO: Add Description
 */

class EchoDatabaseFactory {

    public static function create(array $env): EchoDatabaseConnection {
        if(!isset($env['DBTYPE'])){
            throw new EchoError(EchoError::InvalidEnv);
        }
        return match(strtolower($env['DBTYPE'])){
            'sqlite' => new EchoSQLiteConnection($env),
            default => throw new EchoError(EchoError::InvalidDatabaseConnection)
        };
    }

}