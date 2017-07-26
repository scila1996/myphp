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
		
		$query = $a->insert($b)->toSql();
		$param = var_export($a->getBindings(), true);
		
		$data = "<pre>{$query}\n{$param}</pre>";
		
		$this->response->write($data);
		return $this->response;
	}

}
