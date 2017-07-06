<?php

namespace System\Libraries\Datatable;

use Iterator;
use Closure;

class BaseTable
{

	/** @var array */
	protected $columns = [];

	/** @var array */
	protected $rows = [];

	/** @var Paginator */
	protected $paginator = null;

	/** @var Closure */
	protected $callback = null;

	/** @var array */
	protected $tbclass = ['table', 'table-striped'];

	public function __construct(Iterator $data, Closure $callback = null)
	{
		$this->setData($data);
		$this->setPaginator(new Paginator(count($data), 10, 1));
		if ($callback === null)
		{
			$callback = function ($row) {
				$tr = '';
				foreach ($row as $field)
				{
					$tr .= "<td> $field </td>";
				}
				return "<tr> $tr </tr>";
			};
		}
		$this->setCallback($callback);
	}

	/**
	 * 
	 * @param Closure $callback
	 * @return $this
	 */
	public function setCallback(Closure $callback)
	{
		$this->callback = $callback;
		return $this;
	}

	/**
	 * 
	 * @param array $title
	 * @return $this
	 */
	public function setColumns($title)
	{
		$this->columns = is_array($title) ? $title : func_get_args();
		return $this;
	}

	/**
	 * 
	 * @param Iterator $data
	 * @return $this
	 */
	public function setData(Iterator $data)
	{
		$this->rows = $data;
		return $this;
	}

	/**
	 * 
	 * @param Paginator
	 * @return $this;
	 */
	public function setPaginator(Paginator $paginator)
	{
		$this->paginator = $paginator;
		return $this;
	}

	/**
	 * 
	 * @return array
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * 
	 * @return Iterator
	 */
	public function getData()
	{
		return $this->rows;
	}

	/**
	 * 
	 * @return Paginator
	 */
	public function getPaginator()
	{
		return $this->paginator;
	}

	/**
	 * @return string
	 */
	public function toHtml()
	{
		$cb = $this->callback;
		$tbclass = is_array($this->tbclass) ? implode(' ', $this->tbclass) : $this->tbclass;
		$thead = '';
		$tbody = '';
		$pagi = $this->getPaginator()->toHtml();
		foreach ($this->getColumns() as $column)
		{
			$thead .= "<th> {$column} </th>";
		}
		foreach ($this->getData() as $row)
		{
			$tbody .= $cb($row);
		}
		return "<table class=\"{$tbclass}\"><thead> {$thead} </thead><tbody> {$tbody} </tbody></table>{$pagi}";
	}

}
