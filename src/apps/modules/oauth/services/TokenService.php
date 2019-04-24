<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IToken;
use App\Oauth\Contracts\IOauthServer;

class TokenService implements IToken {
    private $_oauth_server;

    public function __construct(IOauthServer $server) {
        $this->_oauth_server = $server;
    }
    public function handleTokenRequest($request_data) {
        return $this->_oauth_server->handleTokenRequest($request_data);
    }
}