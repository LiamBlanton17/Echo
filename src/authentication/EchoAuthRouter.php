<?php

namespace EchoFramework\Application\Authentication;

use EchoFramework\Application\Routing\EchoRouter;
use EchoFramework\Application\Models\EchoAuthModel;

/**
 * This router sets up some baseline routes an authentication system might need.
 * Extend this router instead of the base EchoRouter to work with Echo's built-in auth system.
 * Must be used in conjunction with EchoAuthMiddleware to provide authentication security.
 * 
 * Use EchoAuthModel, EchoAuthRouter, and EchoAuthMiddleware to fully utilize the built-in authentication system.
 */
class EchoAuthRouter extends EchoRouter {
    
    /**
     * Given a model, connects up some basic routes an authentication system should have.
     * 
     * @param EchoAuthModel $model An EchoAuthModel subclass a developer should build and pass to this router
     */
    public function __construct(EchoAuthModel $model) {
        
        /**
         * Route to log a user in.
         * 
         * @route POST {mount_prefix}/login
         * @handler EchoAuthModel, login
         */
        $this->post('/login', $model('login'));

        /**
         * Route to log a user out.
         * 
         * @route POST {mount_prefix}/logout
         * @handler EchoAuthModel, logout
         */
        $this->post('/logout', $model('logout'));

        /**
         * Route to register a new user.
         * 
         * @route POST {mount_prefix}/register
         * @handler EchoAuthModel, register
         */
        $this->post('/register', $model('register'));

        /**
         * Route to change a user's password.
         * 
         * @route POST {mount_prefix}/change-password
         * @handler EchoAuthModel, changePassword
         */
        $this->post('/change-password', $model('changePassword'));

        /**
         * Route to get info on the currently logged-in user.
         * 
         * @route GET {mount_prefix}/whoiam
         * @handler EchoAuthModel, whoiam
         */
        $this->get('/whoami', $model('whoami'));

        /**
         * Route to delete the currently logged-in user.
         * 
         * @route DELETE {mount_prefix}/delete
         * @handler EchoAuthModel, delete
         */
        $this->delete('/delete', $model('delete'));

    }
}
