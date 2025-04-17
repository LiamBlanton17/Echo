<?php

namespace EchoFramework\Application\Database\Management;

use EchoFramework\Application\Cache\DataBased\EchoDataCachePolicyInterface;
use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Middleware\EchoUseMiddleware;
use EchoFramework\Application\Cache\RouteBased\EchoResponseCachingPolicyInterface;
use EchoFramework\Application\Database\Connection\EchoPDOConnection;
use EchoFramework\Application\Database\Management\EchoTable;
use \InvalidArgumentException;

/**
 * TODO: Add Description
 */

abstract class EchoView {

    use EchoErrors;

    protected EchoTable $table;
    protected EchoPDOConnection $database;

    public static function view(string $tableClass){
        if (!is_subclass_of($tableClass, EchoTable::class)) {
            throw new InvalidArgumentException("EchoTable not provided");
        }
    
        $table = new $tableClass();
        $instance = new static();
        $instance->table = $table;
        return $instance;
    }

    public function with(EchoPDOConnection $database){
        $this->database = $database;
        return $this;
    }

    public function filter(array ...$args){
        
    }

    public function where(string $attribute, string $operator, string $value){

    }

    public function find(mixed $pk){
        
    }

    public function first(int $limit = 1){

    }

    public function all(){

    }

    public function order_by(string $direction = 'ASC'){

    }

}

