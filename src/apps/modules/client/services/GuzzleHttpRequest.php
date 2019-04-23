<?php

namespace App\Client\Services;

use App\Client\Contracts\IHttpRequest;

class GuzzleHttpRequest implements IHttpRequest {
    private $_http_client;


    public function __construct(\GuzzleHttp\Client $client) {
        $this->_http_client = $client;
    }
    
    public function post(array $fields) {        
        $response = $this->_http_client->request('POST', $fields['endpoint'] . $fields['queries']);
        return $response;
    }
}