<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Database\DB;
use PDO;

class TestCtrl extends Controller
{

	public function index()
	{
		$a = DB::query()->table('a');
		$b = DB::query()->table('b')->whereIn('id', [1, 2, 3]);

		$col = ["id", "name"];

		$query = $a->insert($col, $b);
		$data = "<pre>{$query}\n</pre>";

		$this->response->write($data);
		return $this->response;
	}

}
