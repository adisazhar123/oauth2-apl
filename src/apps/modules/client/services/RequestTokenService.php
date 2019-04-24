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

        // return $client_secret;

        $data['endpoint'] = BASE_URL . '/oauth/token';
        $data['queries'] = "grant_type=authorization_code&code=" . $auth_code;
        $data['user'] = $client_id;
        $data['password'] = $client_secret;

        $result = $this->_http_client->postWithAuth($data);
        
        // $ch = curl_init();
        // // do POST request to oauth/token endpoint
        // curl_setopt($ch, CURLOPT_URL, BASE_URL . '/oauth/token');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$client_secret");
        // curl_setopt($ch, CURLOPT_POST, 1);        
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $auth_code);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // $result = curl_exec($ch);
        // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close ($ch);

        $token_result = json_decode($result, true); 
        // return token
        return $token_result;
    }
}