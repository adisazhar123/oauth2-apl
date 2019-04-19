<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;
// use OAuth2\Server as OAuth2Server;

class DashboardController extends Controller
{
    private $_oauth_server;
    private $_response;

    public function initialize() {
        $this->_oauth_server = $this->di->get('oauth_server');
        $this->_response = $this->di->get('response');
    }

    // default routing requires 'Action' 
    public function indexAction()
    {        
        // $this->cookies->set(
        //     'remember-me',
        //     'some value',
        //     time() + 15 * 86400
        // );
        // $this->cookies->send();

        // $rememberMeCookie = $this->cookies->get('remember-me');
        // $value = $rememberMeCookie->getValue();
        // return $value;

        return $this->view->pick('dashboard/index');
    }

    public function helloAction()
    {
        return $this->view->pick('dashboard/hello');
    }

    public function tokenPageAction() {
        return $this->view->pick('dashboard/get-token');
    }

    public function tokenrequestAction() 
    {
        $username= $this->request->get('username');
        $password= $this->request->get('password');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://dev.oauth:8000/oauth/dashboard/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
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
        
        $this->view->setVars(['token_res' => $token_result]);
        return $this->view->pick('dashboard/show-token');
                
    }

    public function tokenAction() {
        $this->_oauth_server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
    }


    public function resourceAction() {
        // Handle a request to a resource and authenticate the access token
        if (!$this->_oauth_server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            $this->_oauth_server->getResponse()->send();
            die;
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }

}


?>