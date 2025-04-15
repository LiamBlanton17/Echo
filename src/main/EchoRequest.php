<?php

namespace EchoFramework\Application\Main;

use EchoFramework\Application\Other\EchoError;
use EchoFramework\Application\Other\EchoErrors;
use EchoFramework\Application\Other\EchoJSON;

use \stdClass;

/**
 * TODO: Add Description
 */

class EchoRequest extends stdClass {

    use EchoErrors;

    protected string $method;  // HTTP request method
    protected string $route;   // Route from the URI
    protected array $headers;  // Array of headers from the request
    protected array $query;    // Array from the query string
    protected EchoJSON $body;  // Object that wraps JSON from the request body
    protected string $uri;     // Full URI of the request
    protected string $completePath; // Full Path of the request
    protected float $timeStamp;  // Time of the request

    protected static ?self $request = NULL;  // Request singleton object

    protected function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->timeStamp = microtime(true);
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->cookies = $_COOKIE;
        $this->query = $_GET;

        $this->completePath = $this->method.' '.$this->route;

        $this->cachingPolicy = NULL;

        $this->headers = $this->_populateHeaders();
    }

    /**
     * @return EchoRequest The singleton object
     */
    public static function get(): self {
        if(is_null(self::$request)){
            self::$request = new EchoRequest();
        }
        return self::$request;
    }

    /**
     * @return NULL
     */
    public function loadJSON() {
        $this->body = EchoJSON::fromRequest();
    }

    /**
     * Using a magic method to make accessing request data more seemless
     * 
     * @param name The field attempting to be accessed
     * @return ?mixed Returns the data or NULL
     */
    public function __get(string $attribute): mixed {
        return match($attribute){
            "timeStamp" => $this->timeStamp,
            "body" => $this->body,
            "headers" => $this->headers,
            "method" => $this->method,
            "route" => $this->route,
            "cookies" => $this->cookies,
            "cachingPolicy" => $this->cachingPolicy,
            "completePath" => $this->completePath,
            default => $this->error(EchoError::InvalidRequestAttribute)
        };
    }

    /**
     * @return array An associative array of headers
     */
    protected function _populateHeaders(): array {

        // Array of headers Echo will reconize
        $headersSet = ['X-CSRF-Token', 'AUTHORIZATION'];

        // Attempt to use getallheaders
        $headers = getallheaders();

        // Attempt to load headers from $_SERVER if not present
        foreach($headersSet as $header){
            if(!isset($headers[$header])){
                $headerKey = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
                $headers[$header] = $_SERVER[$headerKey] ?? '';
            }
        }

        return $headers;
    }

}
