<?php

namespace App\Models;

use System\Libraries\Datatable\BaseTable;
use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Http\Messages\Request;

class Table extends BaseTable
{

	public function __construct(Builder $query, Request $request)
	{
		$page = intval($request->getQueryParam('page', 1));
		$num = intval($request->getQueryParam('record', 10));

		parent::__construct(SQL::execute($query->limit($num)->offset(($page - 1) * $num)), $page, $num);

		$this->getPaginator()->setUrlPattern(function ($page) use ($request) {
			return $request->getUri()->withQuery(
							http_build_query(array_merge($request->getQueryParams(), ['page' => $page]))
			);
		});
	}

}
