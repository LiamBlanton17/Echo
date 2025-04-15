<?php

namespace EchoFramework\Application\Cache\RouteBased;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TODO: Add Description
 */

class EchoTTLPolicy implements EchoResponseCachingPolicyInterface {

    private int $TTL = 60;  // Time to live in seconds
    private bool $reset = TRUE;  // Boolean to reset the cache date or not  
    private bool $global = FALSE;  // Boolean to use the cache on a global or session basis

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
