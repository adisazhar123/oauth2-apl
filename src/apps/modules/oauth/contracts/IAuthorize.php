<?php

namespace App\Oauth\Contracts;

interface IAuthorize {
    public function authorize($post_data);
}