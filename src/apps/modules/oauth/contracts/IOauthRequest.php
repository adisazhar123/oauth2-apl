<?php

namespace App\Oauth\Contracts;

interface IOauthRequest {
    public function createRequest();
}