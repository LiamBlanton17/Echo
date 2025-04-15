<?php

namespace EchoFramework\Application\Database;

/**
 * TODO: Add Descriptions
 */

interface EchoDatabaseConnectionInterface {

    public function verifyEnv(array $env): bool;
    public function configure(array $env);
    public function start();
    public function connection(): mixed;

}
