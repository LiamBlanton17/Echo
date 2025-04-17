<?php

namespace EchoFramework\Application\Database\Management;

use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Middleware\EchoUseMiddleware;
use EchoFramework\Application\Cache\RouteBased\EchoResponseCachingPolicyInterface;
use EchoFramework\Application\Database\Connection\EchoDatabaseFactory;
use stdClass;

/**
 * TODO: Add Description
 */

abstract class EchoTable extends stdClass {

    /**
     * 
     */
    public static function int(): EchoTableField {
        return new EchoTableField('int', 8);
    }

    /**
     *
     */
    public static function bool(): EchoTableField {
        return new EchoTableField('bool', 1);
    }

    /**
     * 
     */
    public static function bigint(): EchoTableField {
        return new EchoTableField('bigint', 16);
    }

    /**
     *
     */
    public static function varchar(int $size = 255): EchoTableField {
        return new EchoTableField('varchar', $size);
    }

    /**
     * 
     */
    public static function datetime(): EchoTableField {
        return new EchoTableField('datetime', 16);
    }

    /** 
     * 
     */
    public static function password(int $size = 32): EchoTableField {
        $field = new EchoTableField('varchar', $size);
        return $field->not_null()->hash();
    }

    /**
     * 
     */
    public static function build(): self {
        $table = new static();
        $table->define();
        return $table;
    }

    /**
     * 
     */
    public function fields(): array {
        return get_object_vars($this);
    }

    /**
     * 
     */
    abstract public function define();

}

