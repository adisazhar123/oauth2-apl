<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class TokenController extends Controller
{
    private $_oauth_server;
    private $_response;
    private $_oauth_request;
    private $_token_service;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
        $this->_oauth_request = $this->di->get('bshaffer_oauth_request');
        $this->_token_service = $this->di->get('token_service');
    }

    public function indexAction() {
        $request_data = $this->_oauth_request->createRequest();
        $token_res = $this->_token_service->handleTokenRequest($request_data);
        $token_res->send();
    }
}