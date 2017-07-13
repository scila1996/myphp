<?php

namespace App\Models;

use System\Libraries\Database\SQL;

class Users
{

	/**
	 *
	 * @var \System\Libraries\Database\Query\Builder
	 */
	protected $query = null;

	public function __construct()
	{
		$this->query = SQL::query()->table('fs_users');
	}

	public function login($user, $pass)
	{
		return SQL::execute($this->query
								->where('username', $user)
								->where('password', md5($pass))
				)->fetch();
	}

}
