<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;

class TokenController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {        
        $this->_response = $this->di->get('response');        
    }

    public function indexAction() {
        $client_id = getenv('CLIENT_ID');
        $client_secret = getenv('CLIENT_SECRET');
        $auth_code = $this->request->getQuery('authorization_code');        
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, BASE_URL . '/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$client_secret");
        curl_setopt($ch, CURLOPT_POST, 1);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $auth_code);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        $token_result = json_decode($result, true);        

        $this->cookies->set(
            'access_token',
            $token_result['access_token'],
            time() + $token_result['expires_in']
        );
        
        $this->cookies->send();        

        $this->_response->redirect('client');
    }
}