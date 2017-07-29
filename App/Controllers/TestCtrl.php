<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Database\DB;
use PDO;

class TestCtrl extends Controller
{

	public function index()
	{
		$query = DB::query();
		$query->select('username')->selectRaw("count(id) as {$query->grammar->wrap('c')}");
		return $query->toSql();
	}

}
