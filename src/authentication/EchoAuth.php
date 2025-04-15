<?php


namespace EchoFramework\Application\Authentication;

use EchoFramework\Application\Main\EchoRequest;

/**
 * TODO: Add Description
 */

trait EchoAuth {

    protected function _login(EchoRequest $req, string $id = '', string $level = 'all'){
        if(empty($id)){
            $id = bin2hex(random_bytes(16));
        }
        $req->session->set('EchoAuthID', $id);
        $req->session->set('EchoAuthLevel', $level);
    }

    protected function _logout(EchoRequest $req){
        $req->session->remove('EchoAuthID');
        $req->session->remove('EchoAuthLevel');
    }

    protected function _isLoggedIn(EchoRequest $req): bool {
        return !empty($req->session->get('EchoAuthID'));
    }

    protected function _getAuthID(EchoRequest $req): ?string {
        return $req->session->get('EchoAuthID');
    }

    protected function _getAuthLevel(EchoRequest $req): ?string {
        return $req->session->get('EchoAuthLevel');
    }
    
}
