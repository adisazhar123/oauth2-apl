<?php


namespace App\Client\Services;

use App\Client\Contracts\IResource;
use App\Client\Contracts\IHttpRequest;

class ResourceService implements IResource {
    private $_http_client;

    public function __construct(IHttpRequest $http) {
        $this->_http_client = $http;        
    }

    public function getFriends($data) {
        try {
            // $response = $this->_http_client->post($data);   

            // $c = new \GuzzleHttp\Client(); 
            // $res = $c->request('POST', $data['endpoint'] . $data['queries']);

            $access_token = 'c063dec456f91d6c1d0417a507c2ac44f1e2a256';
            // and use it to request the resource
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'dev.oauth/oauth/resource?access_token=' . $access_token);
            
            return $response;
            
        } catch(\GuzzleHttp\Exception\BadResponseException $e) { //Every 4xx, 5xx codes must be caught
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return json_encode(['message' => json_decode($responseBodyAsString)->message, 'code' => 401, 'code_desc' => 'Unauthorized']);
        }

        // return json_encode($response);

        return json_encode(['message' => $response->getBody(), 'code' => 200, 'code_desc' => 'Ok']);
    }
}