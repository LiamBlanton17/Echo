<?php


namespace EchoFramework\Application\Cache\DataBased;

/**
 * TODO: Add Description
 */

interface EchoDataCachePolicyInterface {

    /**
     * @return bool Whether or not the cache is valid
     */
    public function validate(): bool;

}