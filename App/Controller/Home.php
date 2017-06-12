<?php

namespace App\Controller;

use System\Libraries\View;

require 'database-5.4/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

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
		$pdo = new \PDO("mysql:host=localhost;dbname=data;charset=utf8", "root", "");
		$connect = new \Illuminate\Database\SqlServerConnection($pdo, "data");
		$query = $connect->table("abc")->select();
		$query->where("id", 5)->join("def", "id", "id");
		echo $query->grammar->compileUpdate($query, array("id" => 5));
		var_dump($query->getBindings());
	}

}
