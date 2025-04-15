<?php

namespace EchoFramework\Application\Authentication;

use EchoFramework\Application\Routing\EchoRouter;
use EchoFramework\Application\Models\EchoAuthModel;

/**
 * TODO: Add Description
 */

class EchoAuthRouter extends EchoRouter {
    
    public function __construct(EchoAuthModel $model){
        
        $this->post('/login', $model('login'));
        $this->post('/logout', $model('logout'));
        $this->post('/register', $model('register'));
        $this->post('/change-password', $model('changePassword'));

        $this->get('/whoiam', $model('whoiam'));
        $this->delete('/delete', $model('delete'));

    }

}