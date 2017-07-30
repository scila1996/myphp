<?php

namespace App\Models;

use System\Libraries\Database\DB;

class Users
{

    /**
     *
     * @var \System\Libraries\Database\Query\Builder
     */
    protected $query = null;

    public function __construct()
    {
        $this->query = DB::query()->table('fs_users');
    }

    public function login($user, $pass)
    {
        return DB::execute($this->query
                                ->where('username', $user)
                                ->where('password', md5($pass))
                )->fetch();
    }

}
