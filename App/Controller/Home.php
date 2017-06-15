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

	public function database()
	{
		$pdo = SQL::getConnect()->getPDO();
		//$pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
		$query = SQL::query();
		$query->select()->distinct()->from("category AS c")->limit(5)->join("user AS u", "u.id", "=", "c.user_id");
		echo "{$query->toSql()} <br />";
		echo SQL::execute($query)->getNumRows();
	}

}
