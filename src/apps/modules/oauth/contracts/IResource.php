<?php

namespace App\Oauth\Contracts;

interface IResource {
    public function verifyResourceRequest($request_data);
    public function getFriends();
}
