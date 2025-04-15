<?php

/**
 * TODO: Add Description
 */

class EchoJSON {

    use EchoErrors;

    protected array $json = [];

    public function __construct(array $json) {
        $this->json = $json;
    }

    /**
     * @param key Key to access this json object
     * @param default Default value if key is not found
     * @return EchoJSON
     */
    public function get(mixed $key, mixed $default = NULL): mixed {
        if(isset($this->json[$key])){
            return $this->json[$key];
        }
        return $default;
    }

    /**
     * @param json Array to append to the json array already in this object
     * @return EchoJSON
     */
    public function append(array $json): self {
        foreach($json as $key => $val){
            if(!isset($this->json[$key])){
                $this->json[$key] = $val;
            }
        }
        return $this;
    }

    /**
     * @return EchoJSON
     */
    public static function fromRequest(): self {
        $requestBody = file_get_contents('php://input');
        if(empty($requestBody) or is_null($requestBody)){
            $requestBody = '[]';
        }
        return new Self(json_decode($requestBody, TRUE));
    }

    /**
     * @return string The JSON to be sent back to the client
     */
    public function encode() {
        return json_encode($this->json);
    }

}