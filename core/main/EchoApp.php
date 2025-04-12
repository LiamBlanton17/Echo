<?php

/**
 * TODO: Add Description
 */

class EchoApp {

    use EchoErrors, EchoRouting;

    protected array $middleware = [];  // An array of middleware
    protected array $routers = [];  // A prefixed array of prefixes and routers
    protected $_handle404; // Error 404 handler

    protected bool $useCache = FALSE;  // Determine if we should lookup cache or not

    public function __construct() {
        $this->_handle404 = $this->_default404();
    }

    /**
     * @param middleware Array of classes, all of which must implement EchoMiddleware
     * @throws \Exception If any class does not exist or does not implement EchoMiddleware
     * @return NULL
     */
    public function use(array $middleware) {
    
        // Validate middleware passed to the function as classes that implement EchoMiddleware
        foreach($middleware as $mw){
            if(!(class_exists($mw) && in_array(EchoMiddleware::class, class_implements($mw)))){
                $this->error(EchoErrorType::InvalidMiddlware);
            }
            
            // Determine if EchoResponseCacheMiddleware is in use
            if($mw === EchoResponseCacheMiddleware::class){
                $this->useCache = TRUE;
            }
        }

        // Save the middleware to the app
        $this->middleware = $middleware;

    }

    /**
     * @return NULL
     */
    public function mount(string $prefix, EchoRouter $router) {
        $this->routers[$prefix] = $router;
    }

    /**
     * @throws \Exception Variety of exceptions can be thrown
     * @return NULL 
     */
    public function start() {

        // Populate the base request/response
        $request = EchoRequest::get();
        $response = EchoResponse::get();

        // Verify the route
        $method = $request->method;
        $route = $request->route;
        $handler = $this->_getHandler($method, $route);
        if(is_null($handler)){
            // If not found, run 404 and output
            $this->_error404($request, $response);
            $response->output();
            return;
        }

        // Determine caching policy - if in use
        if($this->useCache){
            $request->cachingPolicy = $this->_getCachingPolicy($method, $route);
        }

        // Connect the middleware
        $current = $handler;
        foreach(array_reverse($this->middleware) as $mwClass) {
            $mw = new $mwClass();
            $next = $current;
            $current = function($req, $res) use ($mw, $next) {
                $mw->run($req, $res, $next);
            };
        }

        // Run the middleware
        $current($request, $response);

        // Output the response
        $response->output();

    }

    /**
     * @param method HTTP method from the EchoResponse Object
     * @param route Route from the EchoResponse Object
     * @return NULL/Callable
     */
    protected function _getHandler(string $method, string $route): ?callable {

        // Check the routers first
        foreach($this->routers as $prefix => $router){
            if(strpos($route, $prefix) === 0){
                return $router->_getHandler($method, ltrim($route, $prefix)) ?? $this->_handle404;
            }   
        }

        // Check the app
        return $this->getHandler($method, $route) ?? $this->_handle404;
    }

    /**
     * @param method HTTP method from the EchoResponse Object
     * @param route Route from the EchoResponse Object
     * @return NULL/EchoResponseCachingPolicyInterface
     */
    protected function _getCachingPolicy(string $method, string $route): ?EchoResponseCachingPolicyInterface {

        // Check the routers first
        foreach($this->routers as $prefix => $router){
            if(strpos($route, $prefix) === 0){
                return $router->_getCachingPolicy($method, ltrim($route, $prefix)) ?? NULL;
            }   
        }

        // Check the app
        return $this->getCachingPolicy($method, $route) ?? NULL;
    }

    /**
     * @return NULL
     */
    protected function _error404($req, $res) {
        call_user_func($this->_handle404, $req, $res);
    }

    /**
     * @return NULL
     */
    public function set404(callable $new404) {
        $this->_handle404 = $new404;
    }

    /**
     * @return callable
     */
    protected function _default404() {
        return function($res, $req) {
            $method = $res->method;
            $route = $res->route;
            $req->status(404)->json([
                'message' => 'Route not found',
                'route' => $route,
                'method' => $method
            ]);
        };
    }

}
