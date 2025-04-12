<?php

/**
 * TODO: Add Description
 */

class EchoErrorType {
    public const InvalidMiddlware = 'InvalidMiddleware';
    public const NoEchoSession = 'NoEchoSession';
    public const InvalidXCSRF = 'InvalidXCSRF';
    public const NoRequestBody = 'NoRequestBody';
    public const InvalidRequestAttribute = 'InvalidRequestAttribute';
    public const InvalidDatabaseConnection = 'InvalidDatabaseConnection';
    public const InvalidEnv = 'InvalidEnv';
    public const MissingMongoDBResource = 'MissingMongoDBResource';
}

trait EchoErrors {

    protected function error(string $type) {
        throw new Error();
    }

}
