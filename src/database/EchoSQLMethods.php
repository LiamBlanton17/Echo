<?php

namespace EchoFramework\Application\Database;

use \PDO;

/**
 * TODO: Add Description
 */

trait EchoSQLMethods {

    /**
     * 
     */
    public function query(string $query): self {
        $this->stmt = $this->pdo->prepare($query);
        return $this;
    }

    /**
     * 
     */
    public function bind(string $param, mixed $value, ?bool $type = NULL): self {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break; 
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * 
     */
    public function execute(): bool {
        try{        
            return $this->stmt->execute();
        } catch(PDOException $e){
            /**
             * @todo handle errors
             */
        }
        return FALSE;
    }

    /**
     * 
     */
    public function lastID(): mixed {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param string $mode Use array to fecth as an array
     */
    public function single(string $mode = 'object'): mixed {
        $mode = match($mode){
            'array' => PDO::FETCH_ASSOC,
            'object' => PDO::FETCH_OBJ,
            default => PDO::FETCH_OBJ
        };
        return $this->stmt->fetch($mode);
    }

    /**
     * 
     */
    public function all(string $mode = 'object'): mixed {
        $mode = match($mode){
            'array' => PDO::FETCH_ASSOC,
            'object' => PDO::FETCH_OBJ,
            default => PDO::FETCH_OBJ
        };
        return $this->stmt->fetchAll($mode);
    }

    /**
     * 
     */
    public function beginTransaction(): bool {
        return $this->pdo->beginTransaction();
    }

    /**
     * 
     */
    public function cancelTransaction(): bool {
        return $this->pdo->rollBack();
    }

    /**
     * 
     */
    public function commitTransaction(): bool {
        return $this->pdo->commit();
    }

    /**
     * 
     */
    public function count(): int {
        return $this->stmt->rowCount();
    }
    
} 