<?php

/**
 * TODO: Add Description, Add Descriptions to functions
 */

class EchoSession {

    private bool $new = FALSE; // Determines if this is a new session or not

    private string $id;  //PHPSESSID

    public function start(EchoRequest $req) {

        // If no PHPSESSID in cookies, then this is a new session
        if(!isset($req->cookies['PHPSESSID'])){
            $this->new = TRUE;
        }

        // Start the session
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Save the session ID to this object
        $this->id = session_id();
    }

    /**
     * Using a magic method to make accessing request data more seemless
     * 
     * @param string $attribute The field attempting to be accessed
     * @return ?mixed Returns the data or NULL
     */
    public function __get(string $attribute): mixed {
        return match($attribute){
            "id" => $this->id,
            default => $this->error(EchoErrorType::InvalidRequestAttribute)
        };
    }

    public function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_destroy();
        $_SESSION = [];
    }

    public function isnew(): bool {
        return $this->new;
    }

}
