<?php

namespace EchoFramework\Application\Middleware;

/**
 * TODO: Add Description
 */

trait EchoUseMiddleware {

    protected array $middleware = [];  // An array of middleware

    /**
     * @param EchoMiddleware $middleware A middleware class that implements EchoMiddleware
     * @return NULL
     */
    public function use(EchoMiddleware $middleware) {

        // Save the middleware
        $this->middleware[] = $middleware;

    }

    /**
     * @todo Type hinting the $current variable gives IDE errors!
     */
    protected function _connectMiddleware($current): callable {
        foreach(array_reverse($this->middleware) as $mw){
            $next = $current;
            $current = function($req, $res) use ($mw, $next) {
                $mw->run($req, $res, $next);
            };
        }
        return $current;
    }

}