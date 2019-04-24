<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IOauthServer;


class BshafferOauthServer implements IOauthServer {    
    public $oauth_server;
    /**
     * @param OAuth2\Server $server
     */
    public function __construct($server) {
        $this->oauth_server = $server;
    }
    /**
     * @param OAuth2\Request::createFromGlobals()
     * 
     */
    public function verifyResourceRequest($request_data) {
        return $this->oauth_server->verifyResourceRequest($request_data);
    }

    public function getResponse() {
        return $this->oauth_server->getResponse();
    }

    public function validateAuthorizeRequest($request, $response) {
        return $this->oauth_server->validateAuthorizeRequest($request, $response);
    }

    public function handleAuthorizeRequest($oauth_request, $oauth_response, $is_authorized) {
        return $this->oauth_server->handleAuthorizeRequest($oauth_request, $oauth_response, $is_authorized);
    }

    public function handleTokenRequest($request_data) {
        return $this->oauth_server->handleTokenRequest($request_data);
    }

}