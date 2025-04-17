<?php

namespace EchoFramework\Application\Database\Management;

use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Middleware\EchoUseMiddleware;
use EchoFramework\Application\Cache\RouteBased\EchoResponseCachingPolicyInterface;

/**
 * TODO: Add Description
 */

class EchoTableField {

    protected string $type;
    protected string $size;
    protected bool $isPK = FALSE;
    protected bool $isFK = FALSE;
    protected bool $isUnique = FALSE;
    protected bool $isAutoInc = FALSE;
    protected bool $isNotNull = FALSE;
    protected bool $needsHash = FALSE;

    /**
     * Constructor defines this fields type and size
     */
    public function __construct(string $type, string $size){
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Make this field a PK
     */
    public function pk(): self {
        $this->isPK = TRUE;
        return $this;
    }

    /**
     * Make this field a FK
     */
    public function fk(): self {
        $this->isFK = TRUE;
        return $this;
    }

    /**
     * Make this field unique
     */
    public function unique(): self {
        $this->isUnique = TRUE;
        return $this;
    }

    /**
     * Make this field auto increment
     */
    public function auto_inc(): self {
        $this->isAutoInc = TRUE;
        return $this;
    }
    
    /**
     * Make this field not null
     */
    public function not_null(): self {
        $this->isNotNull = TRUE;
        return $this;
    }

    /**
     * Make this field need hash
     */
    public function hash(): self {
        $this->needsHash = TRUE;
        return $this;
    }

}
