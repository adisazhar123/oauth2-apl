<?php

namespace App\Client\Services;

use App\Client\Contracts\IToken;
use App\Client\Contracts\IHttpRequest;

class RequestTokenService implements IToken {
    private $_http_client;

    public function __construct(IHttpRequest $http_client) {
        $this->_http_client = $http_client;    
    }
    public function requestToken($auth_code) {
        // client id and secret kept in client's env
        $client_id = getenv('CLIENT_ID');
        $client_secret = getenv('CLIENT_SECRET');
        
        // build data needed for posting with auth
        $data['endpoint'] = BASE_URL . '/oauth/token';
        $data['queries'] = "grant_type=authorization_code&code=" . $auth_code;
        $data['user'] = $client_id;
        $data['password'] = $client_secret;

        $result = $this->_http_client->postWithAuth($data);

        $token_result = json_decode($result, true); 
        
        return $token_result;
    }
}