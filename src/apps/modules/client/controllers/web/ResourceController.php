<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;

class ResourceController extends Controller {

    private $_response;
    private $_resource_service;

    public function initialize() {
        $this->_response = $this->di->get('response');
        $this->_resource_service = $this->di->get('resource_service');
    }
    
    public function indexAction() {
        $access_token = $this->cookies->get('access_token');  // get the access_token stored in cookies
        // and use it to request the resource        

        $data['queries'] = "access_token=" . $access_token;
        $data['endpoint'] =  BASE_URL . "/oauth/resource?";
        
        // call get friends API
        $response = $this->_resource_service->getFriends($data);

        $this->_response->setJsonContent($response);
        $this->_response->setStatusCode($response['code'], $response['code_desc']);

        //Return the response
        return $this->_response;   
    }

}
