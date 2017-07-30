<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Database\DB;
use PDO;

class TestCtrl extends Controller
{

	public function index()
	{
		/*
		  $query = DB::query()->table('data');
		  $query->select('username')->selectRaw("count(id) as {$query->grammar->wrap('c')}");
		  return $query->toSql();
		 * 
		 */
		$query = DB::query()->select('id', 'title')->table('fs_lands')->limit(10)->whereIn('id', [210, 214]);
		$result = DB::connection()->runQuery($query->toSql(), $query->getBindings());
		return var_export($result->fetchAll(), true);
	}

}
