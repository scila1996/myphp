<?php

namespace App\Controllers;

use System\Core\Controller;

class LoginCtrl extends Controller
{
	public function index()
	{
		$this->view->set('login');
	}
}
