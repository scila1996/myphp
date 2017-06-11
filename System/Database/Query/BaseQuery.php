<?php

namespace System\Database\Query;

use System\Database\Interfaces\QueryInterface;

class BaseQuery implements QueryInterface
{

	protected $_clause = "";
	protected $_table = "";
	protected $_join = array();
	protected $_where = array();
	protected $_group_by = array();
	protected $_having = array();
	protected $_order_by = array();
	protected $_set = array();
	protected $_union = array();
	protected $_limit = -1;
	protected $_offset = 0;
	protected $_param = array();

	private function table($table, $alias = null)
	{
		if (is_string($table))
		{
			$this->_table = $table;
		}
		else
		{
			throw new \InvalidArgumentException("table name MUST be a \"string\"");
		}
		if ($alias and is_string($alias))
		{
			$this->_table = "{$table} AS {$alias}";
		}
	}

	public function select($column = '*')
	{
		$fields = array();
		if (is_string($column))
		{
			$fields = func_get_args();
		}
		else if (is_array($column))
		{
			$fields = $column;
		}
		else
		{
			throw new \InvalidArgumentException("Invalid Argument for SELECT");
		}
		$fields = implode(", ", $fields);
		$this->_clause = "SELECT {$fields}";
	}

	public function from($table, $alias = null)
	{
		$this->table($table, $alias);
	}

	public function where($data)
	{
		$this->_where = array_merge($this->_where, call_user_func_array(array($this, "conditional"), func_get_args()));
	}

}
