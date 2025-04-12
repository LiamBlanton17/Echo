<?php

/**
 * TODO: Add Description
 */

class EchoModel {

    use EchoErrors;

    public function __invoke(string $func): callable {
        return [$this, $func];
    }
    
}

