<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Database\SQL;

class Home extends Controller
{

	protected function index($id = null)
	{
		if ($this->request->isPost())
		{
			echo $this->request->getParam('name');
		}
		else
		{
			$this->view->set('home');
			$this->view->layout('form', 'form');
		}
	}

	protected function mysql()
	{
		var_dump(SQL::connection()->getPDO()->getAvailableDrivers());
		SQL::connection()->getPDO()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
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

	protected function sqlsrv()
	{
		$sql = new \System\Libraries\Database\Connectors\SqlServerConnector();
		$sql->connect([
			'driver' => 'sqlsrv',
			'host' => '192.168.1.21',
			'database' => 'master',
			'username' => 'sa',
			'password' => 123456
		]);
	}

}
