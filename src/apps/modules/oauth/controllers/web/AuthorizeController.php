<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class AuthorizeController extends Controller
{
    private $_oauth_server;
    private $_response;

    private $_authorize_service;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
        $this->_authorize_service = $this->di->get('authorize_service');
    }

    public function indexAction() {
        // Save POST data
        $post_data = $_POST;
        // authorize client, pass in POST data
        $auth = $this->_authorize_service->authorize($post_data);        
        
        // show auth form to authorize
        if($auth['message'] == 'authorize form')
            return $auth['view'];

        // redirect to client URL once authorized
        $this->_response->redirect($auth['client_url']);
    }
}