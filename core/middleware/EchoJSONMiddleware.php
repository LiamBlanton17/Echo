<?php

/**
 * TODO: Add Description
 */

class EchoJSONMiddleware extends EchoBaseMiddleware {

    /**
     * @var $parse determines the amount of cleaning/verification the middleware will do on request
     */
    protected string $parse;

    /**
     * @var $prepare determines the amount of cleaning/verification the middleware will do on response
     */
    protected string $prepare;

    /**
     * @var array $sensitive is an array of strings to hide
     */
    protected array $sensitive = [];

    /**
     * Function used by the user to hide certain strings on response
     * @param array $sensitive is an array of strings to hide
     * @return self
     * 
     * @todo implement it
     */
    public function hide(array $sensitive): self {
        foreach($sensitive as $s){
            $this->sensitive[] = $s;
        }
        return $this;
    }

     /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     * 
     * @todo Add request cleaning
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        $req->loadJSON();
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     * 
     * @todo Add response cleaning
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

    }

}
