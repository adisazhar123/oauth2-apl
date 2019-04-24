<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;

class TokenController extends Controller
{
    private $_oauth_server;
    private $_response;
    private $_token_service;

    public function initialize() {
        // get depencies
        $this->_response = $this->di->get('response');
        $this->_token_service = $this->di->get('token_service');
    }

    public function indexAction() {
        // get auth_code in query string returned from oauth server
        $auth_code = $this->request->getQuery('authorization_code');
        
        // request token with given auth_code
        $token_result = $this->_token_service->requestToken($auth_code);

        // error requesting token
        if(isset($token_result['error'])) {
            return json_encode($token_result);
        }

        // save access_token in cookie
        $this->cookies->set(
            'access_token',
            $token_result['access_token'],
            time() + $token_result['expires_in']
        );
        
        $this->cookies->send();
        
        // redirect to client page
        $this->_response->redirect('client');
    }
}