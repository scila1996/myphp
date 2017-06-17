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
		$query = SQL::query()->table("category", "c");
		$data = [
			["user" => "admin", "pass" => sha1("admin"), "name" => "Trung"],
			["user" => "administrator", "pass" => sha1("admin"), "name" => "Admin"],
		];
		//$query->join(["user", "u"], "c.user_id", "=", "u.id");
		$q = SQL::query()->select()->from($query, "data");
		echo "{$q} <br />";
		var_dump($query->getBindings());
		echo "<br />";
		echo SQL::execute($query)->getNumRows();
	}

}
