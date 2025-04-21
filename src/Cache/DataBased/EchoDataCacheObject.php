<?php

namespace EchoFramework\Application\Cache\DataBased;

/**
 * This is the object used to cache data with.
 * 
 * No real functionality, just a wrapper to store a policy and data together.
 */
class EchoDataCacheObject {

    /**
     * @var EchoDataCachePolicyInterface $policy is the policy to use to validate the cache
     */
    public EchoDataCachePolicyInterface $policy;

    /**
     * @var array $data is the array of data to store
     */
    public array $data;

}
