<?php

namespace EchoFramework\Application\Routing;

// Without this, could not create handlers without models
use Laravel\SerializableClosure\SerializableClosure;

use EchoFramework\Application\Cache\RouteBased\EchoResponseCachingPolicyInterface;

/**
 * This trait is used by EchoApp and EchoRouter
 */

trait EchoRouting {

    protected array $routes = [];  // An array of routes. Populated by route or routers
    
    /**
     * @param handler Function to handle the request
     * @return mixed Returns either just the handler if it wasn't a closure, or a laravel serializable closure
     */
    protected function serializeable($handler): mixed {
        return $handler instanceof \Closure ? new SerializableClosure($handler) : $handler;
    }

    /**
     * @param route Route to set under the GET method
     * @param handler Function to handle the request
     * @return NULL
     */
    public function get(string $route, callable $handler, ?EchoResponseCachingPolicyInterface $cache = NULL) {
        $this->routes['GET'][$route]['handler'] = $this->serializeable($handler);
        $this->routes['GET'][$route]['cache'] = $cache;
    }

    /**
     * @param route Route to set under the POST method
     * @param handler Function to handle the request
     * @return NULL
     */
    public function post(string $route, callable $handler) {
        $this->routes['POST'][$route]['handler'] = $this->serializeable($handler);
    }

    /**
     * @param route Route to set under the PUT method
     * @param handler Function to handle the request
     * @return NULL
     */
    public function put(string $route, callable $handler) {
        $this->routes['PUT'][$route]['handler'] = $this->serializeable($handler);
    }

    /**
     * @param route Route to set under the PATCH method
     * @param handler Function to handle the request
     * @return NULL
     */
    public function patch(string $route, callable $handler) {
        $this->routes['PATCH'][$route]['handler'] = $this->serializeable($handler);
    }

    /**
     * @param route Route to set under the DELETE method
     * @param handler Function to handle the request
     * @return NULL
     */
    public function delete(string $route, callable $handler) {
        $this->routes['DELETE'][$route]['handler'] = $this->serializeable($handler);
    }

    /**
     * @param method Method to find
     * @param route Route to find
     * @return ?callable Returns the handler or NULL
     */
    public function getHandler(string $method, string $route): ?callable {
        $route = '/'.ltrim($route, '/');
        if (isset($this->routes[$method][$route]['handler'])) {
            return $this->routes[$method][$route]['handler'];
        }
        return NULL;
    }

    /**
     * @param method Method to find
     * @param route Route to find
     * @return ?EchoResponseCachingPolicyInterface Returns the handler or NULL
     */
    public function getCachingPolicy(string $method, string $route): ?EchoResponseCachingPolicyInterface {
        $route = '/'.ltrim($route, '/');
        if (isset($this->routes[$method][$route]['cache'])) {
            return $this->routes[$method][$route]['cache'];
        }
        return NULL;
    }

}