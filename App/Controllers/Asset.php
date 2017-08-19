<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\View\Mime;

class Asset extends Controller
{

    public function index($file)
    {
        $this->view->setFileExtension('')->set($file);
        $response = $this->response->withHeader('Content-Type', Mime::TYPES[pathinfo($file, PATHINFO_EXTENSION)]);
        $response->write($this->view->getContent());
        return $response;
    }

}
