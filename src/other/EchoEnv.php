<?php

/**
 * TODO: Add Description
 */

trait EchoEnv {

    public function verifyEnv($env): bool {
        foreach($this->requiredEnv as $key){
            if(!isset($env[$key])){
                return FALSE;
            }
        }
        return TRUE;
    }

}
