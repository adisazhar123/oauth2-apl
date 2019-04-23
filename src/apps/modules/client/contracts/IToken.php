<?php

namespace App\Client\Contracts;

interface IToken {
    public function requestToken($auth_code);

}