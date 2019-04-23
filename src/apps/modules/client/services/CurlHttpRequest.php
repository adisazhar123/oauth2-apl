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
}