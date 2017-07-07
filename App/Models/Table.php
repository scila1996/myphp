<?php

namespace App\Models;

use System\Libraries\Datatable\BaseTable;
use System\Libraries\Datatable\Paginator;
use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Http\Messages\Request;

class Table extends BaseTable
{

	public function __construct(Builder $query, Request $request)
	{
		$page = intval($request->getQueryParam('page', 1));
		$num = intval($request->getQueryParam('record', 10));
		$data = SQL::execute($query->limit($num)->offset(($page - 1) * $num));

		parent::__construct($data);

		$this->tbclass = ['table', 'table-striped'];
		$this->setPaginator(new Paginator($data->getNumRows(), $num, $page));
		$this->getPaginator()->setUrlPattern($this->getUriPattForPaginator($request));
	}

	private function getUriPattForPaginator(Request $request)
	{
		$p = $request->getUri()->getPath();
		$q = $request->getQueryParams();
		unset($q['page']);
		$q = http_build_query($q);
		return "{$p}?{$q}" . ($q ? '&' : '') . 'page=(:num)';
	}

}
