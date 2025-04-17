<?php

namespace EchoFramework\Application\Middleware;

use EchoFramework\Application\Other\EchoError;
use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TODO: Add Description
 */

class EchoBasicRateLimiterMiddleware extends EchoBaseMiddleware {

    use EchoErrors;

    /**
     * @var int $requests is number of request in time period
     */
    protected int $requests = 10;

    /**
     * @var int $time is the time period in seconds
     */
    protected int $time = 30;

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {
        if(!isset($req->session)){
            $this->error(EchoError::NoEchoSession);
        }

        $session = $req->session;
        $rate_limit = $session->get('rate_limit', NULL);

        if(is_null($rate_limit)){
            $rate_limit = ['time' => $this->time + time(), 'requests' => $this->requests];
        } else if($rate_limit['time'] < time()){
            $rate_limit = ['time' => $this->time + time(), 'requests' => $this->requests];
        }

        if($rate_limit['requests'] == 0){
            $res->status(429)->message("Exceeded rate limit: ".$this->requests." requests per ".$this->time." seconds")->output()->finish();
        }
        $rate_limit['requests']--;
        $session->set('rate_limit', $rate_limit);
        
    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {

    }

    /**
     * This function is used to setup the middleware
     */
    public function rate(int $requests, int $time): self {
        $this->requests = $requests;
        $this->time = $time;
        return $this;
    } 

}
