<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{
    // default routing requires 'Action' 
    public function indexAction()
    {
        return $this->view->pick('dashboard/index');
    }

    public function helloAction()
    {
        return $this->view->pick('dashboard/hello');
    }
}


?>