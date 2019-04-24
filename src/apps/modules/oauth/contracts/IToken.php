<?php

namespace App\Oauth\Contracts;

interface IToken {
    public function handleTokenRequest($request_data);
}