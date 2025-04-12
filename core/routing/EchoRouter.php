<?php

/**
 * TODO: Add Description
 */

class EchoRouter {

    use EchoErrors, EchoRouting;
    
    protected $_handle404 = NULL; // Error 404 handler

    /**
     * @param method HTTP method from the EchoResponse Object
     * @param route Route from the EchoResponse Object
     * @return NULL/Callable
     */
    public function _getHandler(string $method, string $route): ?callable {
        return $this->getHandler($method, $route) ?? $this->_handle404;
    }

    /**
     * @param method HTTP method from the EchoResponse Object
     * @param route Route from the EchoResponse Object
     * @return NULL/EchoResponseCachingPolicyInterface
     */
    public function _getCachingPolicy(string $method, string $route): ?EchoResponseCachingPolicyInterface {
        return $this->getCachingPolicy($method, $route) ?? NULL;
    }

    /**
     * @return NULL
     */
    public function set404(callable $new404) {
        $this->_handle404 = $new404;
    }

}
