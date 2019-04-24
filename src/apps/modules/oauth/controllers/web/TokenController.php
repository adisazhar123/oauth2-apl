<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class TokenController extends Controller
{
    private $_oauth_server;
    private $_response;
    private $_oauth_request;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
        $this->_oauth_request = $this->di->get('bshaffer_oauth_request');
    }

    public function indexAction() {        
        $token_res = $this->_oauth_server->handleTokenRequest($this->_oauth_request->createRequest());
        $token_res->send();
    }
}