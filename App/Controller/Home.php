<?php

namespace App\Controller;

use System\Libraries\View;

class Home extends \System\Core\Controller
{

	public function index($id = null)
	{
		View::add("home.php", array(
			"content" => $id
		));
	}

	public function test($id)
	{
		View::add("test.php", array(
			"content" => var_export($this->request->getParsedBody(), TRUE)
		));
	}

}
