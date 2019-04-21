<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;

class ResourceController extends Controller {

    private $_response;

    public function initialize() {        
        $this->_response = $this->di->get('response');        
    }
    
    public function indexAction() {        
        $access_token = $this->cookies->get('access_token');  // get the access_token stored in cookies
        // and use it to request the resource

        $client = new \GuzzleHttp\Client();
        
        try {
            $response = $client->request('POST', 'dev.oauth/oauth/resource?access_token=' . $access_token);
        } catch(\GuzzleHttp\Exception\BadResponseException $e) { //Every 4xx, 5xx codes must be caught
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $this->_response->setJsonContent(json_decode($responseBodyAsString, true));
            $this->_response->setStatusCode(401, 'Unauthorized');
                        
            return $this->_response;
        }

        //Set the content of the response
        $this->_response->setJsonContent(json_decode($response->getBody(), true));

        //Return the response
        return $this->_response;   
    }

}
