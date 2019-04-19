<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class ResourceController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
    }

    public function resourceAction() {
        // Handle a request to a resource and authenticate the access token
        if (!$this->_oauth_server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            $this->_oauth_server->getResponse()->send();
            die;
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }

}