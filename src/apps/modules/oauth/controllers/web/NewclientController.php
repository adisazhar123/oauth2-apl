<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
use App\Oauth\Models\OauthClient;

class NewclientController extends Controller
{
    private $_request;
    private $_response;
    // private $_db_connection;

    public function initialize() {        
        $this->_response = $this->di->get('response');
        $this->_request = $this->di->get('request');
    }

    public function indexAction() {
        $clients = OauthClient::find();
        $this->view->setVar('clients', $clients);
        return $this->view->pick('oauth/index');
    }

    public function storeAction() {
        // generate client_secret & client_id
        $client_secret = bin2hex(random_bytes(32));
        $client_id = bin2hex(random_bytes(32));

        // insert to DB
        $oauth_client = new OauthClient();
        $oauth_client->client_id = $client_id;
        $oauth_client->client_secret = $client_secret;
        $oauth_client->create();        

        // return value to client
        $this->response->redirect($_SERVER['HTTP_REFERER']);        
    }
}