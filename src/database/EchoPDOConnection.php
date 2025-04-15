<?php

namespace EchoFramework\Application\Database;

use EchoFramework\Application\Other\EchoErrors;

/**
 * TODO: Add Description
 */

abstract class EchoPDOConnection implements EchoDatabaseConnection {
    
    use EchoErrors, EchoSQLMethods;

    protected mixed $pdo;
    protected mixed $stmt;

    public function pdo(): mixed {
        return $this->pdo;
    }

}