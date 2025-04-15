<?php

namespace EchoFramework\Application\Other;

use \Exception;

/**
 * EchoError is the class Echo uses to provide consistent errors and error messages
 */
class EchoError extends Exception {

    /**
     * @var const A list of const error types acting as an enum
     */
    public const GeneralError = 'GeneralError';
    public const InvalidMiddlware = 'InvalidMiddleware';
    public const NoEchoSession = 'NoEchoSession';
    public const InvalidXCSRF = 'InvalidXCSRF';
    public const NoRequestBody = 'NoRequestBody';
    public const InvalidRequestAttribute = 'InvalidRequestAttribute';
    public const InvalidDatabaseConnection = 'InvalidDatabaseConnection';
    public const InvalidEnv = 'InvalidEnv';
    public const MissingMongoDBResource = 'MissingMongoDBResource';

}

/**
 * EchoErrors is the trait included in any class that can use an EchoErrorType
 */
trait EchoErrors {

    protected function error(string $type = EchoError::GeneralError) {
        throw new EchoError($type);
    }

}
