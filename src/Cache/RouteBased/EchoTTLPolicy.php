<?php

namespace EchoFramework\Application\Cache\RouteBased;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TTL (time to live) response-based caching polciy
 * 
 * Use this class as your route base caching policy to implement a TTL policy
 */
class EchoTTLPolicy implements EchoResponseCachingPolicyInterface {

    /**
     * @var int $TTL is the time to live for this cache in secions
     */
    private int $TTL = 60;

    /**
     * @var bool $reset is a flag to reset (or not) the TTL if the cache is hit
     */
    private bool $reset = TRUE;
    
    /**
     * @var bool $global is a flag to cache at a global (every user uses this cache) or session level
     */
    private bool $global = FALSE;

    /**
     * Construct a new TTL policy
     * 
     * @param int $TTL is the time to live in seconds
     * @param bool $reset is a flag to reset (or not) the TTL if the cache is hit
     * @param bool $global is a flag to cache at a global (every user uses this cache) or session level 
     */
    public function __construct(int $TTL = 60, bool $reset = TRUE, bool $global = FALSE) {
        $this->TTL = $TTL;
        $this->reset = $reset;
        $this->global = $global;
    }

    /**
     * @return bool Whether to cache at a global or session level
     */
    public function global(): bool {
        return $this->global;
    }

    /**
     * @param EchoRequest The request object
     * @param string The suspected location of the cache
     *
     * @return EchoResponse|NULL Returns a response object if a cache is found, else NULL
     */
   public function find(EchoRequest $req, string $location): ?EchoResponse {

        // Setting the variable to return 
        $result = NULL;

        // Check if file exists and that filemtime is valid
        if(!file_exists($location)) {
            return $result;
        }
        $lastModified = filemtime($location);
        if ($lastModified === false) {
            return $result;
        }

        // If valid, within the time to live, get the response object and return it
        $valid = time() - $lastModified < $this->TTL;
        if($valid){
            $result = unserialize(file_get_contents($location));

            // If we need to reset the counter, do so
            if($this->reset){
                touch($location);
            }
        }

        return $result;
    }

}
