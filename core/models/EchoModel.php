<?php

/**
 * TODO: Add Description
 */

class EchoModel {

    use EchoErrors;

    /**
     * @var $params is an array of parameters you can add to a model call in a route
     * @example 
     *  myModel('MethodName', ['name' => 'echo']);
     *  Inisde the model: $this->params['name'] ==> 'echo'
     */
    protected array $params;

    public function __invoke(string $func, array $params = []): callable {
        $this->params = $params;
        return [$this, $func];
    }
    
}

