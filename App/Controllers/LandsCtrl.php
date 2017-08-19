<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\Lands\DataList;

class LandsCtrl extends Controller
{

    public function index()
    {
        $this->view->set('lands/page');
    }

    public function ajaxGetData()
    {
        $data = new DataList($this);
        return $this->response->withJson($data->get());
    }

}
