<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IResource;
use App\Oauth\Contracts\IOauthServer;

class ResourceService implements IResource {
    private $_oauth_server;

    public function __construct(IOauthServer $oauth_server) {
        $this->_oauth_server = $oauth_server;
    }
    
    public function getFriends() {
        return ['success' => true, 'message' => INCLUDE dirname(__FILE__)  . '/../data/friends.php', 'code' => 200, 'code_desc' => 'Ok'];
    }

    public function verifyResourceRequest($request_data) {
        if (!$this->_oauth_server->verifyResourceRequest($request_data)) {
            return ['success' => false, 'message' => 'Access token is wrong', 'code' => 401, 'code_desc' => 'Unauthorized'];
        }

        // return 'ok';

        return $this->getFriends();

    }

}