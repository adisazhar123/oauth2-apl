<?php

namespace App\Client\Services;

use App\Client\Contracts\IHttpRequest;

class CurlHttpRequest implements IHttpRequest {    
    public function postWithoutAuth(array $fields) {        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $fields['endpoint'] . $fields['queries']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        return $result;
    }

    public function postWithAuth(array $fields) {
        $ch = curl_init();

        // do POST request to oauth/token endpoint
        curl_setopt($ch, CURLOPT_URL, $fields['endpoint']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $fields['user'] . ':' . $fields['password']);
        curl_setopt($ch, CURLOPT_POST, 1);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields['queries']);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        return $result;
    }
}