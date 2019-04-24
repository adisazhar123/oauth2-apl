<?php

namespace App\Oauth\Contracts;

interface IOauthResponse{
    public function sendResponse();
    public function getInstance();
    public function getHttpHeader($name);
}