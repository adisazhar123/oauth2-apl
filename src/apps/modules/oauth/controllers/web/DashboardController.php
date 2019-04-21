<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;

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
        return $this->view->pick('dashboard/index');
    }    

}


?>