<?php

namespace App\Controllers;

use System\Core\Controller;

class TestCtrl extends Controller
{

    public function index()
    {
        $this->view->set('test');
    }

}
