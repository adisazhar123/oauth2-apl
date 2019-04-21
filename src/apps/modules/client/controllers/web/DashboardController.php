<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{    
    private $_response;

    public function initialize() {                
        $this->view->setVar('oauth_client', $this->oauth_client);
    }
    
    public function indexAction()    
    {        
        return $this->view->pick('dashboard/index');
    }


}


?>