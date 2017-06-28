<?php

namespace System\Libraries\Datatable;

use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;

class SQLTable extends BaseTable
{

	public function __construct(Builder $query, $page = 1, $num = 10)
	{
		$query->limit($num)->offset(($page - 1) * 10);
		parent::__construct(SQL::execute($query));
	}

}
