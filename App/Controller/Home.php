<?php

namespace App\Controller;

use System\Libraries\View;

class Home extends \System\Core\Controller
{

	public function index($id = null)
	{
		View::add("test.php", array(
			"content" => $this->request->getUri()->getPath()
		));
	}

}
