<?php

namespace App\Oauth\Contracts;

interface IOauthServer {
    public function verifyResourceRequest($request_data);
    public function validateAuthorizeRequest($request, $response);
    public function getResponse();
    public function handleAuthorizeRequest($oauth_request, $oauth_response, $is_authorized);
    public function handleTokenRequest($request_data);
}