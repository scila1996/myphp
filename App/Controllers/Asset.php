<?php

namespace App\Controllers;

use System\Core\Controller;

class Asset extends Controller
{

    public function index($file)
    {
        $response = $this->response->withHeader('Content-Type', mime_content_type(
                        $this->view->setFileExtension('')->set($file)->file)
        );
        $response->write($this->view->getContent());
        return $response;
    }

}
