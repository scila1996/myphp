<?php

namespace App\Models\Table;

use System\Libraries\Datatable\BaseTable;
use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Http\Messages\Request;

class Table extends BaseTable
{

	/**
	 * 
	 * @param Builder $query
	 * @param Request $request
	 */
	public function __construct(Builder $query, Request $request)
	{
		$page = intval($request->getQueryParam('page', 1));
		$num = intval($request->getQueryParam('record', 10));
		$data = SQL::execute($query->limit($num)->offset(($page - 1) * $num));

		parent::__construct($data, $page, $num);
		$this->setColumns($data->getFields());
		$this->getPaginator()->setUrlPattern(function ($page) use ($request) {
			return $request->getUri()->withQuery(
							http_build_query(array_merge($request->getQueryParams(), ['page' => $page]))
			);
		})->setTotalItems($this->countTotal(clone $query));
	}

	protected function countTotal(Builder $query)
	{
		return SQL::execute($query->offset(null)->count())->fetch()->aggregate;
	}

	/**
	 * 
	 * @param object $row
	 * @return string
	 */
	public function renderRow($row, $n)
	{
		return "<tr>" . implode('', array_map(function($field) {
							return "<td> {$field} </td>";
						}, (array) $row)) . "</tr>";
	}

	/**
	 * @return string
	 */
	public function toHtml()
	{
		$first = $this->getPaginator()->getCurrentPageFirstItem();
		$head = implode(array_map(function($title) {
					return "<th> {$title} </th>";
				}, $this->getColumns()));
		$body = implode(array_map(function($row) use (&$first) {
					return $this->renderRow($row, $first++);
				}, iterator_to_array($this->getData())));
		return <<<table
<table class="table table-striped">
<thead>
		{$head}
</thead>
		<tbody>
		{$body}
		</tbody>
</table>
<div><b> Showing {$this->getPaginator()->getCurrentPageFirstItem()} to {$this->getPaginator()->getCurrentPageLastItem()} of {$this->getPaginator()->getTotalItems()} entries </b></div>
{$this->getPaginator()->toHtml()}
table;
	}

}
