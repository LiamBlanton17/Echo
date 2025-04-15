<?php

namespace EchoFramework\Application\Middleware;

use EchoFramework\Application\Main\EchoRequest;
use EchoFramework\Application\Main\EchoResponse;

/**
 * TODO: Add Description
 */

class EchoCORSMiddleware extends EchoBaseMiddleware {

    /**
     * @var array $origin determines which origins CORS will allow
     */
    protected array $origin;

    /**
     * @var array $methods determines which methods CORS will allow
     */
    protected array $methods;

    /**
     * @var array $headers determines which methods CORS will allow
     */
    protected array $headers;

    /**
     * This function is run before the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _before(EchoRequest $req, EchoResponse $res) {

        // Die on an OPTIONS request
        if($req->method === 'OPTIONS'){
            $res->status(204)->output();
            die();
        }

    }

    /**
     * This function is run after the handler
     * @param EchoRequest $req EchoRequest from the app
     * @param EchoResponse $res EchoResponse from the app
     * @return NULL
     */
    protected function _after(EchoRequest $req, EchoResponse $res) {
        
        // CORS is setup during initial setup of the middleware, don't allow changes
        $appEnv = strtolower($req->env['APP_ENV']);
        $origin = $this->origin;
        $methods = $this->methods;
        $headers = $this->headers;

        // Use prod if invalid app_env used
        $origin = isset($origin[$appEnv]) ? $origin[$appEnv] : $origin['prod'];
        $methods = isset($methods[$appEnv]) ? $methods[$appEnv] : $methods['prod'];
        $headers = isset($headers[$appEnv]) ? $headers[$appEnv] : $headers['prod'];

        // Adding in echo powered-by header
        $headers[] = 'X-Powered-By';

        $res->addHeader('Access-Control-Allow-Origin', implode(",", $origin));
        $res->addHeader('Access-Control-Allow-Methods', implode(",", $methods));
        $res->addHeader('Access-Control-Allow-Headers', implode(",", $headers));

    }

    /**
     * This function controls what CORS policy to use for a dev enviorment
     * @param array $origin used to define allowed origins for CORS
     * @param array $methods used to define allowed methods for CORS
     * @param array $headers used to define allowed headers for CORS
     * @return self
     */
    public function dev(array $origin = ["*"], array $methods = ["*"], array $headers = ["*"]): self {
        $this->origin['dev'] = $origin;
        $this->methods['dev'] = $methods;
        $this->headers['dev'] = $headers;
        return $this;
    }

    /**
     * This function controls what CORS policy to use for a test enviorment
     * @param array $origin used to define allowed origins for CORS
     * @param array $methods used to define allowed methods for CORS
     * @param array $headers used to define allowed headers for CORS
     * @return self
     */
    public function test(array $origin = ["*"], array $methods = ["*"], array $headers = ["*"]): self {
        $this->origin['test'] = $origin;
        $this->methods['test'] = $methods;
        $this->headers['test'] = $headers;
        return $this;
    }

    /**
     * This function controls what CORS policy to use for a production enviorment
     * @param array $origin used to define allowed origins for CORS
     * @param array $methods used to define allowed methods for CORS
     * @param array $headers used to define allowed headers for CORS
     * @return self
     */
    public function prod(array $origin = ["*"], array $methods = ["GET"], array $headers = ["Content-Type", "Authorization"]): self {
        $this->origin['prod'] = $origin;
        $this->methods['prod'] = $methods;
        $this->headers['prod'] = $headers;
        return $this;
    }

}
