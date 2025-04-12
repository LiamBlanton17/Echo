<?php

/**
 * TODO: Add Description
 */

class EchoDatabaseMiddleware implements EchoMiddleware {
    
    use EchoErrors;

    /**
     * @param req EchoRequest from the app
     * @param res EchoResponse from the app
     * @param next This is the run function for the next middleware
     * @return NULL
     */
    public function run(EchoRequest $req, EchoResponse $res, callable $next) {
        $req->database = $this->_connect($req->env);
        $next($req, $res);
    }

    /**
     * @param env From the echo.env file
     * @return EchoDatabaseConnectionInterface A connection to the database
     */
    public function _connect(array $env): EchoDatabaseConnectionInterface {

        // Verify that the provided class is a databaseclass
        $class = $env['DBCLASS'];
        if(!(class_exists($class) && in_array(EchoDatabaseConnectionInterface::class, class_implements($class)))){
            $this->error(EchoErrorType::InvalidDatabaseConnection);
        }

        // Connect to the database
        $connection = new $class();
        if(!$connection->verifyEnv($env)){
            $this->error(EchoErrorType::InvalidEnv);
        }
        $connection->configure($env);

        // Return
        return $connection;
    }

}
