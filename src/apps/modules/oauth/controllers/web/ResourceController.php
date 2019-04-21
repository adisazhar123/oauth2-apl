<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;

class ResourceController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
    }
    
    public function indexAction() {
        $this->_response->setContent("application/json");

        // Handle a request to a resource and authenticate the access token
        if (!$this->_oauth_server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) { // invalid access token
            $err = $this->_oauth_server->getResponse();
            $status_code = $err->getStatusCode();
            $err_body = $err->getResponseBody();
            // Send response to client
            $this->_response->setStatusCode($status_code, 'Unauthorized');
            $this->_response->setContent(json_encode(['success' => false, 'message' => $err_body, 'code' => $status_code]));
            $this->_response->send();
            return;            
        }
        // Send response to client
        $this->_response->setStatusCode(200, 'OK');
        $this->_response->setContent(json_encode(['success' => true, 'friends' => INCLUDE dirname(__FILE__)  . '/../../data/friends.php']));
        $this->_response->send();        
    }

}