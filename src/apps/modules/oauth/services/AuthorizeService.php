<?php

namespace App\Oauth\Services;

use App\Oauth\Contracts\IAuthorize;
use App\Oauth\Contracts\IOauthServer;
use App\Oauth\Contracts\IOauthRequest;
use App\Oauth\Contracts\IOauthResponse;

class AuthorizeService implements IAuthorize {
    private $_oauth_server;
    private $_oauth_response;
    private $_oauth_request;

    public function __construct(IOauthServer $oauth_server, IOauthResponse $oauth_res, IOauthRequest $oauth_req) {
        $this->_oauth_server = $oauth_server;
        $this->_oauth_response = $oauth_res;
        $this->_oauth_request = $oauth_req;
    }

    public function authorize($post_data) {
        // validate the authorize request
        if (!$this->_oauth_server->validateAuthorizeRequest($this->_oauth_request->createRequest(), $this->_oauth_response->getInstance())) {
            $this->_oauth_response->send();
            die;
        }
        // display an authorization form
        // TODO: retrieve from view and style it!
        if (empty($post_data)) {
            return ['message' => 'authorize form', 'view' => '<form method="post">
            <label>Do You Authorize TestClient?</label><br />
            <p>TestClient will receive <strong>all</strong> your TCBook friends.</p>
            <input type="submit" name="authorized" value="yes">
            <input type="submit" name="authorized" value="no">
            </form>'];
        }
        
        $is_authorized = ($post_data['authorized'] === 'yes');
        $this->_oauth_server->handleAuthorizeRequest($this->_oauth_request->createRequest(), $this->_oauth_response->getInstance(), $is_authorized);
       
        if ($is_authorized) {
            $code = substr($this->_oauth_response->getHttpHeader('Location'), strpos($this->_oauth_response->getHttpHeader('Location'), 'code=')+5, 40);            
            return ['message' => 'authorized', 'client_url' => 'client/token?authorization_code=' . $code];
            // $this->_oauth_response->redirect('client/token?authorization_code=' . $code);
        } else {
            $code = substr($this->_oauth_response->getHttpHeader('Location'), strpos($this->_oauth_response->getHttpHeader('Location'), 'code=')+5, 40);            
            return ['message' => 'unauthorized', 'client_url' => 'client'];
        }
    }
}