<?php

namespace App\Controller;

use System\Libraries\View;

class Home extends \System\Core\Controller
{

	public function index($id = null)
	{
		$data = $this->request->getParsedBody();
		View::add("home.php", [
			"content" => 123
		]);
	}

}
