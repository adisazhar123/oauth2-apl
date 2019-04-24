<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IOauthResponse;

class BshafferOauthResponse implements IOauthResponse {
    private $_response;

    public function __construct(\OAuth2\Response $res) {
        $this->_response = $res;        
    }

    public function getInstance() {
        return $this->_response;
    }

    public function sendResponse() {
        $this->_response->send();
    }
    
    public function getHttpHeader($name) {
        return $this->_response->getHttpHeader($name);
    }
    
}