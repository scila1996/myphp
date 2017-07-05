<?php

namespace System\Libraries\Datatable;

use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;

class SQLTable extends BaseTable
{

	public function __construct(Builder $query, $page = 1, $num = 10)
	{
		$query->limit($num)->offset(($page - 1) * 10);
		$data = SQL::execute($query);
		parent::__construct($data);
		$this->paginator = new Paginator($data->getNumRows(), $num, $page);
	}

	/**
	 * @param object
	 * @return string
	 */
	public function renderRow($row)
	{
		$tr = '';
		foreach ($row as $field)
		{
			$tr .= "<td> $field </td>";
		}
		return "<tr> $tr </tr>";
	}

	/**
	 * @return string
	 */
	public function toHtml()
	{
		$thead = '';
		$tbody = '';
		$pagi = $this->getPaginator()->toHtml();
		foreach ($this->getColumns() as $column)
		{
			$thead .= "<th> {$column} <th>";
		}
		foreach ($this->getData() as $row)
		{
			$tbody .= $this->renderRow($row);
		}
		return "<table class=\"table\"><thead> {$thead} </thead><tbody> {$tbody} </tbody></table>{$pagi}";
	}

}
