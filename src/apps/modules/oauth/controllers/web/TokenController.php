<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class TokenController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
    }

    public function indexAction() {
        $this->_oauth_server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();           
    }
}