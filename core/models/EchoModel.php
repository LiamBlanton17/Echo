<?php

/**
 * TODO: Add Description
 */

abstract class EchoModel extends stdClass {

    use EchoErrors;

    /**
     * @var $params is an array of parameters you can add to a model call in a route
     * @example 
     *  myModel('MethodName', ['name' => 'echo']);
     *  Inisde the model: $this->params['name'] ==> 'echo'
     */
    protected array $params;

    /**
     * @param string $func is the name of the handler to call
     * @param array $params is an array of parameters to add to the model
     * @return callable Will return a callable function to the router/app
     */
    public function __invoke(string $func, array $params = []): callable {
        $this->params = $params;
        return [$this, $func];
    }
    
}

