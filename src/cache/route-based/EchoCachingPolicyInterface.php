<?php

/**
 * TODO: Add Description
 */

interface EchoResponseCachingPolicyInterface {

    /**
     * @param EchoRequest The request object
     * @param string The suspected location of the cache
     * @return EchoResponse|NULL Returns a response object if a cache is found, else NULL
     */
    public function find(EchoRequest $req, string $location): ?EchoResponse;

}
