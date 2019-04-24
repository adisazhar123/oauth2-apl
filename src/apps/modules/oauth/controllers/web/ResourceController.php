<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;

class ResourceController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        // $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
        $this->_oauth_server = $this->di->get('oauth_server');
    }
    
    public function indexAction() {
        $oauth_request = $this->di->get('bshaffer_oauth_request');
        $resource_req = $oauth_request->createRequest();


        if (!$this->_oauth_server->verifyResourceRequest($resource_req)) {            
            $this->_response->setStatusCode(401, 'Unauthorized');
            $this->_response->setContent(json_encode(['success' => false, 'message' => 'Access token is wrong', 'code' => 401, 'code_desc' => 'Unauthorized']));
            $this->_response->send();
            return;
        }

        $this->_response->setStatusCode(200, 'OK');
        $this->_response->setContent(json_encode(['success' => true, 'message' => INCLUDE dirname(__FILE__)  . '/../../data/friends.php', 'code' => 200, 'code_desc' => 'Ok']));
        $this->_response->send();
        return;
    }

}