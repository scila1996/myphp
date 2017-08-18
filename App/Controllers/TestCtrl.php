<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Util\File\File;

class TestCtrl extends Controller
{

    public function index()
    {
        return File::getContentType('View/lands/page.php');
    }

}
