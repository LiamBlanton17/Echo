<?php

/**
 * TODO: Add Description
 */

class EchoResponse {

    use EchoErrors;

    protected int $status;  // HTTP reponse status

    protected EchoJSON $body;  // Object that wraps JSON for the response body

    protected static ?self $reponse = NULL;  // Response singleton object

    protected function __construct() {
        
    }

    /**
     * @return EchoResponse The singleton object
     */
    public static function get(): self {
        if(is_null(self::$reponse)){
            self::$reponse = new EchoResponse();
        }
        return self::$reponse;
    }

    /**
     * @param status HTTP status code to respond to the request
     * @return self
     * @todo Use enum for statuses instead of an int, and verify it is a valid status
     */
    public function status(int $status = 200): self {
        $this->status = $status;
        return $this;
    }

    /**
     * @param json PHP Associative array to be converted to the json response
     * @return self
     * @todo Use enum for statuses instead of an int, and verify it is a valid status
     */
    public function json(array $json): self {
        if(!isset($this->body)){
            $this->body = new EchoJSON($json);
        } else {
            $this->body->append($json);
        }
        return $this;
    }

    /**
     * @return NULL
     */
    public function output() {
        // TODO: more to output? headers, ect
        http_response_code($this->status);
        echo $this->body->encode();
    }

}
