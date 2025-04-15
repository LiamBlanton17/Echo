<?php

/**
 * TODO: Add Description
 */

class EchoResponseCache {

    /**
     * Retrieves a cached EchoResponse from a file based on the request path
     *
     * @param EchoRequest $req The request object
     * @param string $path The base directory where cached responses are stored
     * @return EchoResponse|NULL The cached response if it exists, or null
     */
    public static function get(EchoRequest $req): ?EchoResponse {

        // Each caching policies find functions will either return the cached object or NULL
        return $req->cachingPolicy->find($req, self::_location($req));
    }

    /**
     * Stores a serialized EchoResponse in a file cache based on the request path
     *
     * @param EchoRequest $req The request object 
     * @param EchoResponse $res The response object to be cached
     * @param string $path The base directory where cached responses are stored
     * @return void
     */
    public static function put(EchoRequest $req, EchoResponse $res) {
        $cache = serialize($res);
        file_put_contents(self::_location($req), $cache);
    }

    /**
     * Generates a cache file path using a base path and a hashed version of the complete path
     * Checks if this is session based or global
     *
     * @param EchoRequest $req The request object 
     * @return string The full path to the cache file
     */
    private static function _location(EchoRequest $req): string {
        $folder = $req->env['CACHEPATH'];
        $route = $req->completePath; 
        $global = $req->cachingPolicy->global();

        $key = bin2hex(($global ? '' : $req->session->id).$route);
        return $folder.'/'.$key;
    }

}