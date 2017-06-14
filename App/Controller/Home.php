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
		$pdo = SQL::getConnect()->getPDO();
		$pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
		$query = SQL::query()->select()->from("category");
		$query->select()->from("category AS c")->join("user AS u", "u.id", "=", "c.user_id");
		foreach (SQL::execute($query) as $row)
		{
			echo "{$row->name} <br />";
		}
	}

}
