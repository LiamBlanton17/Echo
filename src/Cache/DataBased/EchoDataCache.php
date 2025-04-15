<?php


namespace EchoFramework\Application\Cache\DataBased;

use EchoFramework\Application\Main\EchoRequest;

/**
 * TODO: Add Description
 */

class EchoDataCache {

    private string $path; // Path to cache too
    private string $PHPSESSID; // PHP Session ID

    public function __construct(EchoRequest $req) {
        $this->path = $req->env['CACHEPATH'];
        $this->PHPSESSID = $req->session->id;
    }

    public function find(string $key, bool $global = FALSE): ?array {
        $location = $this->_location($key, $global);

        if(!file_exists($location)) {
            return NULL;
        }

        $cacheObj = unserialize(file_get_contents($location));
        if($cacheObj->policy->validate()){
            return $cacheObj->data;
        }
        return NULL;
    }

    public function put(string $key, array $data, EchoDataCachePolicyInterface $policy, bool $global = FALSE) {
        $location = $this->_location($key, $global);

        $cacheObj = new EchoDataCacheObject();
        $cacheObj->policy = $policy;
        $cacheObj->data = $data;

        $cache = serialize($cacheObj);
        file_put_contents($location, $cache);
    }

    private function _location(string $key, bool $global): string {
        $extendedKey = bin2hex(($global ? '' : $this->PHPSESSID).'datacache'.$key);
        return $this->path.'/'.$extendedKey;
    }

}
