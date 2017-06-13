<?php

namespace App\Controller;

use System\Libraries\View;
use System\Libraries\Database\SQL;

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
		$collect = SQL::execute(SQL::query()->select()->from("category"));
		echo $collect->fetch()->name;
		/*
		  $connect = new Connector();
		  $query = $connect->query();
		  $query->select()->from("category AS c")->join("user AS u", "u.id", "=", "c.user_id");
		  echo $connect->execute($query);
		 * 
		 */
	}

}
