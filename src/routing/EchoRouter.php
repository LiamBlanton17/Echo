<?php

namespace EchoFramework\Application\Routing;

use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Middleware\EchoUseMiddleware;
use EchoFramework\Application\Cache\RouteBased\EchoResponseCachingPolicyInterface;

/**
 * TODO: Add Description
 */

class EchoRouter {

    use EchoErrors, EchoRouting, EchoUseMiddleware;
    
    protected $_handle404 = NULL; // Error 404 handler

    /**
     * @param method HTTP method from the EchoResponse Object
     * @param route Route from the EchoResponse Object
     * @return NULL/Callable
     */
    public function _getHandler(string $method, string $route): ?callable {
        $handler = $this->getHandler($method, $route) ?? $this->_handle404;

        if(is_null($handler)){
            return NULL;
        }
        $middle = $this->_connectMiddleware($handler);
        return $middle;
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
