<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\View\Manager;
use System\Libraries\Database\SQL;

class Home extends Controller
{

	public function index($id = null)
	{
		view();
		Manager::add("home.php", array(
			"content" => $id
		));
	}

	public function database()
	{
		SQL::getConnect()->getPDO()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
		$select = SQL::query()->table("category", "c");
		$select->select()->where(function($where) {
			$where->where("name", "like", "%a%");
		});
		$join = SQL::query()->select()->from("user")->where('user', 'test');
		$query = SQL::query()->select('*', 'c.name as cname')->from($select, 'c')->join([$join, 'u'], 'u.id', '=', 'c.user_id');
		echo "{$query} <br />";
		var_dump($query->getBindings());
		echo "<br />";
		foreach (SQL::execute($query) as $row)
		{
			echo "{$row->user} : {$row->cname} <br />";
		}
	}

}
