<?php

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

        $current = $this->_connectMiddleware($handler);

        return $current;
    }
    
}

