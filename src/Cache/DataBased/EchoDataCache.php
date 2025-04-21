<?php

namespace EchoFramework\Application\Cache\DataBased;

use EchoFramework\Application\Main\EchoRequest;

/**
 * An object of this class will be attached to the EchoRequest object if using EchoDataCacheMiddleware middleware.
 * Use this object as an abstraction to cache data. The data must be placed into an array.
 * 
 * Must be used with EchoDataCacheMiddleware.
 */
class EchoDataCache {

    /**
     * @var string $path is the path to the cache, will come from the echo.env file
     */
    private string $path;

    /**
     * @var string 
     */
    private string $PHPSESSID; // PHP Session ID

    /**
     * @param EchoRequest $req is the EchoRequest object
     */
    public function __construct(EchoRequest $req) {
        $this->path = $req->env['CACHEPATH'];
        $this->PHPSESSID = $req->session->id;
    }

    /**
     * Get a cached object via a key. Null is returned if it does not exist or the policy was violated.
     * 
     * @param string $key is the cache key to search
     * @param bool $global is wether the cache was cached at a session or global level
     * @return ?array will return the cached array, or null if nothing was found or the policy was violated
     */
    public function find(string $key, bool $global = FALSE): ?array {
        $location = $this->_location($key, $global);

        if(!file_exists($location)) {
            return NULL;
        }

        $cacheObj = unserialize(file_get_contents($location));

        // Validate the policy
        if($cacheObj->policy->validate()){
            return $cacheObj->data;
        }

        return NULL;
    }

    /**
     * Put an array of data into cache, overwriting if the key already exists.
     * 
     * @param string $key is the cache key to use on cache
     * @param array $data is the array of data to cache
     * @param EchoDataCachePolicyInterface $policy is the policy apply to the cache
     * @param bool $global is a flag to set whether this cache will be at the global (all sessions) or session level
     * @return void
     */
    public function put(string $key, array $data, EchoDataCachePolicyInterface $policy, bool $global = FALSE) {
        $location = $this->_location($key, $global);

        $cacheObj = new EchoDataCacheObject();
        $cacheObj->policy = $policy;
        $cacheObj->data = $data;

        $cache = serialize($cacheObj);
        file_put_contents($location, $cache);
    }

    /**
     * Generate a location to store the cache.
     * 
     * @param string $key is the key provided by the developer to use
     * @param bool $global is whether or not to create this key at a session of global level
     * @return string the location to store or find the hash
     */
    private function _location(string $key, bool $global): string {
        $extendedKey = bin2hex(($global ? '' : $this->PHPSESSID).'datacache'.$key);
        return $this->path.'/'.$extendedKey;
    }

}
