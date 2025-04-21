<?php

namespace EchoFramework\Application\Authentication;

use EchoFramework\Application\Main\EchoRequest;

/**
 * The trait should be used with an EchoModel to give access to these helper functions.
 * By default the EchoAuthModel uses this trait.
 * Must be used in conjuction with EchoAuthMiddleware to provide authenticaiton security.
 * Must be used in conjuction with EchoSessionMiddleware to utilize sessions.
 * 
 * Use EchoAuthModel, EchoAuthRouter and EchoAuthModel to fully utilize the built in Authenticaiton system.
 */
trait EchoAuth {

    /**
     * Used to login a user.
     * 
     * @param EchoRequest $req is the request object
     * @param string $id is the id to set the user too. Not required, but if you want to tie this login to a User in your databse
     * @param string $level is the level of access to grant. This is set to all by default, but feel free to use this if you need it
     * @return void
     */
    protected function _login(EchoRequest $req, string $id = '', string $level = 'all'){
        if(empty($id)){
            $id = bin2hex(random_bytes(16));
        }
        $req->session->set('EchoAuthID', $id);
        $req->session->set('EchoAuthLevel', $level);
    }

    /**
     * Used to logout a user.
     * 
     * @param EchoRequest $req is the request object
     * @return void
     */
    protected function _logout(EchoRequest $req){
        $req->session->remove('EchoAuthID');
        $req->session->remove('EchoAuthLevel');
    }

    /**
     * Used to check if the user is logged in.
     * 
     * @param EchoRequest $req is the request object
     * @return bool if the user is logged in or not
     */
    protected function _isLoggedIn(EchoRequest $req): bool {
        return !empty($req->session->get('EchoAuthID'));
    }

    /**
     * Used to get the ID of the user.
     * 
     * @param EchoRequest $req is the request object
     * @return ?string either the user ID or NULL if the user is not logged in
     */
    protected function _getAuthID(EchoRequest $req): ?string {
        return $req->session->get('EchoAuthID');
    }

    /**
     * Used to get the level of access of the user.
     * 
     * @param EchoRequest $req is the request object
     * @return ?string either the user level or NULL if the user is not logged in
     */
    protected function _getAuthLevel(EchoRequest $req): ?string {
        return $req->session->get('EchoAuthLevel');
    }
    
}
