<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class AuthorizeController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
    }

    public function indexAction() {
        $request = \OAuth2\Request::createFromGlobals();
        $response = new \OAuth2\Response();

        // validate the authorize request
        if (!$this->_oauth_server->validateAuthorizeRequest($request, $response)) {
            $response->send();
            die;
        }
        // display an authorization form
        // TODO: retrieve from view and style it!
        if (empty($_POST)) {
            exit('
            <form method="post">
            <label>Do You Authorize TestClient?</label><br />
            <p>TestClient will receive <strong>all</strong> your TCBook friends.</p>
            <input type="submit" name="authorized" value="yes">
            <input type="submit" name="authorized" value="no">
            </form>');
        }
        
        $is_authorized = ($_POST['authorized'] === 'yes');
        $this->_oauth_server->handleAuthorizeRequest($request, $response, $is_authorized);
       
        if ($is_authorized) {                    ;
            $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);            
            // return "OMG IM HERE" . $code;
            // redirect to client URL
            $this->_response->redirect('client/token?authorization_code=' . $code);                
        }     
    }
}