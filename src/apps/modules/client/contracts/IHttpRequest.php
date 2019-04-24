<?php

namespace App\Client\Contracts;

interface IHttpRequest {
    public function postWithoutAuth(array $fields);
    public function postWithAuth(array $fields);
}