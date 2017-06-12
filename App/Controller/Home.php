<?php

namespace App\Controller;

use System\Libraries\View;
use System\Libraries\Database\Query\Builder;

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

	public function database()
	{
		$builder = new Builder();
		$builder->select()->from("category AS c")->join("user AS u", "u.id", "=", "c.user_id");
		echo $builder->exists();
	}

}
