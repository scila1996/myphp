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
		// SQL::getConnect()->getPDO()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
		$select = SQL::query()->table("category", "c");
		$select->select()->where(function($where) {
			$where->where("name", "like", "%a%");
		});
		$join = SQL::query()->select()->from("user")->where('user', 'test');
		$query = SQL::query()->select()->from($select, 'c')->join([$join, 'u'], 'u.id', '=', 'c.user_id');
		echo "{$query} <br />";
		var_dump($query->getBindings());
		echo "<br />";
		echo SQL::execute($query)->getNumRows();
	}

}
