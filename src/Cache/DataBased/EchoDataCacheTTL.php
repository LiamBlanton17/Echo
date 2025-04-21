<?php

namespace EchoFramework\Application\Cache\DataBased;

/**
 * This class will create a TTL (time to live) object to cache
 * 
 * Time to live is just a timer until the cache is no longer invalid
 */
class EchoDataCacheTTL implements EchoDataCachePolicyInterface {

    /**
     * @var int $TTL is the time in seconds to live
     */
    private int $TTL;

    /**
     * @var int $deathTime is the time the policy will expire
     */
    private int $deathTime;
    
    /**
     * @var bool $reset is a flag on whether the time should be reset when the cache is accessed
     */
    private bool $reset = FALSE; 

    /**
     * @param int $TTL is the time to live of the cache, defaulted to 60 seconds
     * @param bool $reset is whether or not to reset the cache, default to false
     */
    public function __construct(int $TTL = 60, bool $reset = FALSE) {
        $this->TTL = $TTL + time();
        $this->deathTime = $TTL + time();
        $this->reset = $reset;
    }

    /**
     * @return bool Whether or not the cache is valid
     */
    public function validate(): bool {
        $isValid = $this->deathTime > time();

        // Reset the cache if needed
        if($isValid && $this->reset){
            $this->deathTime += $this->TTL;
        }

        return $isValid;
    }

}
