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
        // $ch = curl_init();
        // // do POST request to oauth/token endpoint
        // curl_setopt($ch, CURLOPT_URL, $data['endpoint'] . $data['queries']);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // $result = curl_exec($ch);
        // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close ($ch);

        $result = $this->_http_client->postWithoutAuth($data);
        
        $decoded_res = json_decode($result, true);
        
        return ['message' => $decoded_res['message'], 'code' => $decoded_res['code'], 'code_desc' => $decoded_res['code_desc']];
    }
}