<?php

namespace System\Libraries\Datatable;

use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;

abstract class Table
{

	public $page = 1;
	public $page_size = 10;
	protected $class = array('table', 'table-striped', 'table-hover');
	protected $columns = array();
	private $_use_db = TRUE;
	private $_total = 0;
	private $_page_max = 1;

	public function __construct()
	{
		if (($p = Request::get('page')) and is_numeric($p))
		{
			$this->page = intval($p);
		}
		if (($s = Request::get('psize')) and is_numeric($s))
		{
			$this->page_size = intval($s);
		}
	}

	abstract protected function Source();

	protected function row($data, $index)
	{
		$html = '<tr>';
		foreach ($data as $k => $v)
		{
			$html .= "<td> $v </td>";
		}
		$html .= '</tr>';
		return $html;
	}

	protected function dataEmpty()
	{
		return '<tr class="info"><td colspan="25"><b> Không có dữ liệu </b></td></tr>';
	}

	final public function get()
	{
		$head = '';
		$body = '';
		foreach ($this->columns as $str)
		{
			$head .= "<th> $str </th>";
		}
		if ($this->_use_db)
		{
			$db_query = $this->Source();
			if (!($db_query instanceof DB_Query))
			{
				throw new Exception\Table_DBError('DB_Query Object is not set !');
			}
			$n_start = ($this->page - 1) * $this->page_size;
			$db_query->limit($this->page_size, $n_start);
			echo $db_query->getQuery();
			$result = $db_query->execute();
			if (!($result instanceof DB_Result))
			{
				throw new Exception\Table_DBError('DB_Result is empty !');
			}
			$this->_total = $result->num_rows();
			$page_max = ceil($this->_total / $this->page_size);
			$this->page_max = $page_max;
			if ($this->_total)
			{
				if ($n_start >= 0 and $n_start < $this->_total)
				{
					$i = $n_start;
					foreach ($result as $row)
					{
						$body .= $this->row($row, ++$i);
					}
				}
				else
				{
					throw new Exception\Table_InvalidPageNumber('This page is not exist !');
				}
			}
			else
			{
				$body .= $this->dataEmpty();
			}
		}
		// Return html
		$class = implode(' ', $this->class);
		$html = "<table class=\"$class\">" .
				"<thead> $head </thead>" .
				"<tbody> $body </tbody>" .
				"</table>";
		$pager = new Pagination($this->_total, $this->page_size, $this->page);
		$html .= "<div class=\"form-group\"> {$pager->get()} </div>";
		return $html;
	}

}
