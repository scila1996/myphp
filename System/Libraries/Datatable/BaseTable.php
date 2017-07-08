<?php

namespace System\Libraries\Datatable;

use Iterator;

class BaseTable
{

	/** @var array */
	protected $columns = [];

	/** @var array */
	protected $rows = [];

	/** @var Paginator */
	protected $paginator = null;

	/** @var integer */
	protected $page = null;

	/** @var integer */
	protected $total = null;

	/** @var integer */
	protected $num = null;

	public function __construct(Iterator $data, $page = 1, $num = 10)
	{
		$this->setData($data)->setPaginator(new Paginator(
				$this->total = $data->count(), $this->num = $num, $this->page = $page
		));
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
		$thead = '';
		$tbody = '';
		$pagi = $this->getPaginator()->toHtml();
		foreach ($this->getColumns() as $column)
		{
			$thead .= "<th> {$column} </th>";
		}
		foreach ($this->getData() as $row)
		{
			$tbody .= '<tr>' . implode('', array_map(function($field) {
								return "<td> {$field} </td>";
							}, (array) $row)) . '</tr>';
		}
		return "<table class=\"table\"><thead> {$thead} </thead><tbody> {$tbody} </tbody></table>{$pagi}";
	}

}
