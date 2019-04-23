<?php

namespace App\Client\Contracts;

interface IHttpRequest {
    public function post(array $fields);
}