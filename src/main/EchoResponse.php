<?php

namespace EchoFramework\Application\Main;

use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Other\EchoJSON;

/**
 * TODO: Add Description
 */

class EchoResponse {

    use EchoErrors;

    protected int $status;  // HTTP reponse status
    protected array $headers = [];  // Headers to send
    protected array $cookies = [];  // Cookies to use

    protected EchoJSON $body;  // Object that wraps JSON for the response body

    protected static ?self $reponse = NULL;  // Response singleton object

    protected function __construct() {}

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
     * 
     */
    public function addHeader(string $key, string $value): self {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * 
     */
    public function removeHeader(string $key): self {
        unset($this->headers[$key]);
        return $this;
    }

    /**
     * 
     */
    public function cookie(string $name, string $value, array $options = []): self {
        $defaults = [
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax',
            'path' => '/',
            'expires' => time() + 3600,
        ];
        $options = array_merge($defaults, $options);
        $this->cookies[$name] = ['value' => $value, 'options' => $options]; 
        return $this;
    }


    /**
     * @return self
     */
    public function output(): self {
        
        // Verify status and body
        $this->status = $this->status ?? 500;
        $this->body = $this->body ?? new EchoJSON(['message' => 'No body was set. Server error.']);

        // Set headers
        foreach($this->headers as $key => $header){
            header("$key: $header");
        }

        // Adding in the Echo header
        header("X-Powered-By: Echo");

        // Use cookies
        foreach($this->cookies as $key => $cookie) {
            $value = $cookie['value'];
            $expires = gmdate("D, d-M-Y H:i:s T", $cookie['options']['expires']);;
            $path = $cookie['options']['path'];
            $secure = $cookie['options']['secure'] ? '1' : '0';
            $httponly = $cookie['options']['httponly'] ? '1' : '0';
            $samesite = $cookie['options']['samesite'];

            header("Set-Cookie: $key={$value}; expires={$expires}; path={$path}; secure={$secure}; httponly={$httponly}; samesite={$samesite}");
        }

        // Set reponse code
        http_response_code($this->status);

        // Send response
        echo $this->body->encode();

        return $this;
    }

    /**
     * Use this function as an alias to die/exit. Call it after calling output
     * 
     * @return NULL
     */
    public function finish() {
        exit;
    }

}
