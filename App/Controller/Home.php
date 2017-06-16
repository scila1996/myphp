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
		$query = SQL::query();
		$data = [
			["user" => "admin", "pass" => sha1("admin"), "name" => "Trung"],
			["user" => "administrator", "pass" => sha1("admin"), "name" => "Admin"],
		];
		$query->table("admin")->update(["pass" => sha1("12345678")])->where("user", "admin");
		echo "{$query} <br />";
		var_dump($query->getBindings());
		echo "<br />";
		echo SQL::execute($query);
	}

}
