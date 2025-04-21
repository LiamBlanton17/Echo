<?php


namespace EchoFramework\Application\Cache\DataBased;

/**
 * An interface to implement a data cache policy
 */
interface EchoDataCachePolicyInterface {

    /**
     * @return bool Whether or not the cache is valid
     */
    public function validate(): bool;

}
