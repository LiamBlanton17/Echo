<?php

namespace EchoFramework\Application\Models;

use EchoFramework\Application\Middleware\EchoUseMiddleware;
use EchoFramework\Application\Other\EchoErrors;

use \stdClass;

/**
 * TODO: Add Description
 */

abstract class EchoModel extends stdClass {

    use EchoErrors, EchoUseMiddleware;
    
    /**
     * @param string $func is the name of the handler to call
     * @return callable Will return a callable function to the router/app
     */
    public function __invoke(string $func): callable {
        $handler = [$this, $func];

        //Perhaps bring this back with the new Laravel Serializable Closure!?
        //$current = $this->_connectMiddleware($handler);

        return $handler;
    }

}

