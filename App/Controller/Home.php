<?php

namespace App\Controller;

use System\Database\DB;

class Home extends \System\Core\Controller
{

	public function index($id = null)
	{
		$query = DB::query("SELECT * FROM user");
		echo $query->execute()->first()->user;
	}

}
