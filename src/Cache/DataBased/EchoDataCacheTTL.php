<?php


namespace EchoFramework\Application\Cache\DataBased;

/**
 * TODO: Add Description
 */

class EchoDataCacheTTL implements EchoDataCachePolicyInterface {

    private int $TTL;  // Time to live
    private int $deathTime;  // Time the policy will expire
    private bool $reset = FALSE;  // Boolean to reset the cache date or not  

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

        if($isValid && $this->reset){
            $this->deathTime += $this->TTL;
        }

        return $isValid;
    }

}