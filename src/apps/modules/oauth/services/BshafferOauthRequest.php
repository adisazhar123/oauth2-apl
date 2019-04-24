<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IOauthRequest;

class BshafferOauthRequest implements IOauthRequest {
    public $test = 'test bro';
    public function __construct() {
    }

    public function createRequest() {
        $request = \OAuth2\Request::createFromGlobals();        
        return $request;
    }
}