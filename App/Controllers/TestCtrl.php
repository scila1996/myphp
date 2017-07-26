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
		$a->selectRaw('?, ?')->setBindings([1, 2]);
		$this->response->write(var_export($a->getRawBindings(), true));
		return $this->response;
	}

}
