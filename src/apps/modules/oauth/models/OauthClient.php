<?php

namespace App\Oauth\Models;

use Phalcon\Mvc\Model;

class OauthClient extends Model
{
    public $client_id;
    public $client_secret;

    public function initialize()
    {
        $this->setSource('oauth_clients');
    }

    public function getClientDetails() {
        return [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
    }

}
