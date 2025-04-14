<?php

/**
 * TODO: Add Description
 */

class EchoApp {

    use EchoErrors, EchoRouting, EchoUseMiddleware;

    protected array $routers = [];  // A prefixed array of prefixes and routers
    protected $_handle404; // Error 404 handler

    public function __construct() {

        // Setting the default 500 handlers
        [$exceptionHandler, $errorHandler] = $this->_default500s();
        //set_exception_handler($exceptionHandler);
        //set_error_handler($errorHandler);

        // Setting the default 404 handler
        $this->_handle404 = $this->_default404();

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
        $request->cachingPolicy = $this->_getCachingPolicy($method, $route);

        // Connect the middleware
        $current = $this->_connectMiddleware($handler);

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
                return $router->_getHandler($method, substr($route, strlen($prefix))) ?? $this->_handle404;
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
    protected function _default404(): callable {
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

    /**
     * @return array An array of callable 500 functions
     */
    protected function _default500s(): array {

        // Handle exceptions 
        $exceptionHandler = function(Throwable $e){
            $res = EchoResponse::get();
            $res->status(500)->json([
                'message' => 'Internal server error. Debugging support to be added.'
            ])->output();
            die();
        };

        // Handle errors
        $errorHandler = function(int $errno, string $errstr, string $errfile, int $errline){
            $res = EchoResponse::get();
            $res->status(500)->json([
                'message' => 'Internal server error. Debugging support to be added.'
            ])->output();
            die();
        };

        return [$exceptionHandler, $errorHandler];
    }

}
