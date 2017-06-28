<?php

namespace System\Libraries\Datatable;

use Iterator;

class BaseTable
{

	protected $columns = [];
	protected $rows = [];

	public function __construct(Iterator $data)
	{
		$this->setData($data);
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
		return $this->row;
	}

}
