<?php

namespace System\Database;

class DB_Query
{

	CONST DESC = 'DESC';
	CONST ASC = 'ASC';
	CONST SUBQUERY = 1;

	private $_query = '';
	private $_join = array();
	private $_where = array();
	private $_group_by = array();
	private $_having = array();
	private $_order_by = array();
	private $_set = array();
	private $_union = array();
	private $_limit = -1;
	private $_offset = 0;
	private $_param = array();

	public function __construct($query_str = '', $parameter = array())
	{
		if ($query_str)
			$this->_query = $query_str;
		if ($parameter)
			$this->_param = $parameter;
		DB::open();
	}

	private function _get_condition($data)
	{
		$where_return = array('expression' => array(), 'param' => array());
		$get = function($column, $operator, $param) use (&$where_return) {
			$expr = $column;
			switch (($operator = trim(strtoupper($operator))))
			{
				case 'EXISTS':
				case 'NOT EXISTS':
					$expr = "$operator ({$param->getQuery()})";
					$param = $param->getParams();
					break;
				case 'BETWEEN':
				case 'NOT BETWEEN':
					$expr = "$column $operator ? AND ?";
					break;
				case 'IN':
				case 'NOT IN':
					if ($param instanceof self)
					{
						$expr = "$column $operator ({$param->getQuery()})";
						$param = $param->getParams();
					}
					else
					{
						$expr = "$column $operator (" . implode(', ', array_fill(0, count($param), '?')) . ")";
					}
					break;
				default:
					if ($operator)
					{
						$expr = "$column $operator ?";
					}
					if (!is_array($param))
					{
						$param = array($param);
					}
			}
			array_push($where_return['expression'], $expr);
			$where_return['param'] = array_merge($where_return['param'], $param);
		};
		switch (func_num_args())
		{
			case 1:
				$d = func_get_arg(0);
				if (is_string($d))
				{
					$get($d, '', array());
				}
				else if (is_array($d))
				{
					foreach ($d as $k => $w)
					{
						if (is_int($k) and is_string($w))
						{
							$get($d, '', $w);
						}
						else
						{
							$c = $k;
							$o = '=';
							$p = $w;
							if (is_int($k) and is_array($w))
							{
								$c = $w[0];
								switch (count($w))
								{
									case 2:
										$p = $w[1];
										break;
									case 3:
										$o = $w[1];
										$p = $w[2];
										break;
								}
							}
							$get($c, $o, $p);
						}
					}
				}
				break;
			case 2:
				$get(func_get_arg(0), '=', func_get_arg(1));
				break;
			case 3:
				$get(func_get_arg(0), func_get_arg(1), func_get_arg(2));
				break;
		}
		return $where_return;
	}

	private function _where($condition, $argument)
	{
		if ($argument instanceof \Closure)
		{
			$query = new self();
			$argument($query);
			array_push($this->_where, (empty($this->_where) ? '' : "$condition ") . '(' . implode(' ', $query->_where) . ')');
			$this->_param = array_merge($this->_param, array_values($query->_param));
		}
		else
		{
			$query = call_user_func_array(array($this, '_get_condition'), $argument);
			foreach ($query['expression'] as $expr)
			{
				array_push($this->_where, (empty($this->_where) ? '' : "$condition ") . "$expr");
			}
			$this->_param = array_merge($this->_param, array_values($query['param']));
		}
		return $this;
	}

	private function _join($type, $argument)
	{
		$param = array();
		$alias = '';
		$table = $argument[0];
		$condition = $argument[1];
		if ($table instanceof self)
		{
			$param = array_values($table->getParams());
			$table = "({$table->getQuery()})";
		}
		switch (count($argument))
		{
			case 3:
				$alias = $argument[1];
				$condition = $argument[2];
		}
		array_push($this->_join, strtoupper($type) . " JOIN {$this->_table_alias($table, $alias)}" . ($condition ? " ON $condition" : ''));
		$this->_param = array_merge($this->_param, $param);
		return $this;
	}

	private function _table_alias($table, $alias)
	{
		return $alias ? "$table AS $alias" : $table;
	}

	public function select($columns = '*')
	{
		$columns = implode(', ', func_num_args() ? (is_array($columns) ? $columns : func_get_args()) : array($columns));
		$this->_query = "SELECT $columns ";
		return $this;
	}

	public function from($table, $alias = '')
	{
		if ($table instanceof \Closure)
		{
			$query = new self();
			$table($query);
			$table = $query;
		}
		if ($table instanceof self)
		{
			$this->_query .= "FROM {$this->_table_alias($table->getQuery(self::SUBQUERY), $alias)} ";
			$this->_param = array_merge($this->_param, $table->getParams());
		}
		else
		{
			$this->_query .= "FROM {$this->_table_alias($table, $alias)} ";
		}
		return $this;
	}

	/**
	 * Shorthand ->select('*')->from('table') 
	 * @param string
	 * @param string
	 */
	public function table($table, $alias = '')
	{
		return $this->select()->from($table, $alias);
	}

	public function where($data)
	{
		return $this->_where('AND', ($data instanceof \Closure) ? $data : func_get_args());
	}

	public function orWhere($data)
	{
		return $this->_where('OR', ($data instanceof \Closure) ? $data : func_get_args());
	}

	public function whereIsNull($column)
	{
		return $this->where($column, 'IS', NULL);
	}

	public function whereNotNull($column)
	{
		return $this->where($column, 'IS NOT', NULL);
	}

	public function whereIn($column, $data)
	{
		return $this->where($column, 'IN', $data);
	}

	public function whereNotIn($column, $data)
	{
		return $this->where($column, 'NOT IN', $data);
	}

	public function whereBetween($column, $data)
	{
		return $this->where($column, 'BETWEEN', $data);
	}

	public function whereNotBetween($column, $data)
	{
		return $this->where($column, 'NOT BETWEEN', $data);
	}

	public function whereExists($select)
	{
		return $this->where('', 'EXISTS', $select);
	}

	public function whereNotExists($select_query)
	{
		return $this->where('', 'NOT EXISTS', $select_query);
	}

	/** Custom WHERE with parameters */
	public function whereRaw($condition, $param = array())
	{
		return $this->where($condition, '', $param);
	}

	private function _union($type, $query)
	{
		$union = 'UNION' . ($type == 'ALL' ? " $type" : '');
		if ($query instanceof \Closure)
		{
			$subquery = new self();
			$query($subquery);
			$query = $subquery;
			$union = "$union {$query->getQuery(self::SUBQUERY)}";
		}
		else
		{
			$union = "$union {$query->getQuery()}";
		}
		array_push($this->_union, $union);
		$this->_param = array_merge($this->_param, array_values($query->getParams()));
		return $this;
	}

	public function union($query)
	{
		return $this->_union('', $query);
	}

	public function unionAll($query)
	{
		return $this->_union('ALL', $query);
	}

	public function groupBy($column)
	{
		$this->_group_by = is_array($column) ? $column : func_get_args();
		return $this;
	}

	public function having($data)
	{
		$condition = call_user_func_array(array($this, '_get_condition'), func_get_args());
		$this->_having = $condition['expression'];
		$this->_param = array_values($condition['param']);
		return $this;
	}

	public function havingRaw($condition, $param = array())
	{
		return $this->having($condition, '', $param);
	}

	public function orderBy($column, $sort = self::DESC)
	{
		if (is_array($column))
		{
			$this->_order_by = $column;
		}
		else if (is_string($column) and in_array($sort, array(self::ASC, self::DESC)))
		{
			$this->_order_by = array($column => $sort);
		}
		else
		{
			$this->_order_by = func_get_args();
		}
		return $this;
	}

	public function insert($table, $data)
	{
		$query = '';
		$param = array();
		switch (func_num_args())
		{
			case 2:
				if ($data instanceof self)
				{
					$query = "INSERT INTO $table {$data->getQuery()}";
					$param = $data->getParams();
				}
				else if (is_array($data))
				{
					$cols = implode(', ', array_keys($data));
					$vals = implode(', ', array_fill(0, count($data), '?'));
					$query = "INSERT INTO $table ($cols) VALUES ($vals) ";
					$param = array_values($data);
				}
				break;
			case 3:
				$cols = implode(', ', $data);
				$select = func_get_arg(3);
				$query = "INSERT INTO $table ($cols) {$select->getQuery()}";
				$param = $select->getParams();
				break;
		}
		$this->_query = $query;
		$this->_param = array_values($param);
		return $this;
	}

	public function update($table, $alias = '')
	{
		$this->_query = "UPDATE {$this->_table_alias($table, $alias)} ";
		return $this;
	}

	public function delete($table = '')
	{
		if ($table)
		{
			$this->_query = "DELETE $table ";
		}
		else
		{
			$this->_query = 'DELETE ';
		}
		return $this;
	}

	public function set($data)
	{
		if (!is_array($data))
		{
			switch (func_num_args())
			{
				case 1:
					$data = array($data);
					break;
				case 2:
					$data = array($data => func_get_arg(1));
					break;
			}
		}
		$set = array();
		$param = array();
		foreach ($data as $column => $value)
		{
			if (is_int($column))
			{
				array_push($set, $value);
			}
			else if (is_array($value))
			{
				array_push($set, $column);
				$param = array_merge($param, array_values($value));
			}
			else
			{
				array_push($set, "$column = ?");
				array_push($param, $value);
			}
		}
		$this->_set = array_values($set);
		$this->_param = array_merge($this->_param, array_values($param));
		return $this;
	}

	/** @return $this */
	public function join($table)
	{
		return call_user_func_array(array($this, 'innerJoin'), func_get_args());
	}

	public function innerJoin($table)
	{
		return $this->_join('inner', func_get_args());
	}

	public function leftJoin($table)
	{
		return $this->_join('left', func_get_args());
	}

	public function rightJoin($table)
	{
		return $this->_join('right', func_get_args());
	}

	/** for MySQL database */
	public function limit($n, $offset = 0)
	{
		$this->_limit = $n;
		return $this->offset($offset);
	}

	public function offset($n)
	{
		$this->_offset = $n;
		return $this;
	}

	public function getQuery()
	{
		$query = $this->_query;
		if (!empty($this->_join))
		{
			$join = implode(' ', $this->_join);
			$query .= "$join ";
		}
		if (!empty($this->_set))
		{
			$set = implode(', ', $this->_set);
			$query .= "SET $set ";
		}
		if (!empty($this->_where))
		{
			$where = implode(' ', $this->_where);
			$query .= "WHERE $where ";
		}
		if (!empty($this->_group_by))
		{
			$group = implode(', ', $this->_group_by);
			$query .= "GROUP BY $group ";
		}
		if (!empty($this->_having))
		{
			$having = implode(' ', $this->_having);
			$query .= "HAVING $having ";
		}
		if (!empty($this->_order_by))
		{
			$order = implode(', ', array_map(function($column, $sort) {
						return is_int($column) ? $sort : "$column $sort";
					}, array_keys($this->_order_by), $this->_order_by));
			$query .= "ORDER BY $order ";
		}
		if ($this->_limit > 0 and $this->_offset >= 0)
		{
			$query .= "LIMIT $this->_limit OFFSET $this->_offset ";
			switch (DB::$db_driver)
			{
				case 'mysql':
					$query = preg_replace('/(^\s*SELECT(?=\s))/i', '$1 SQL_CALC_FOUND_ROWS', $query);
					break;
			}
		}
		$query = trim($query);
		if (!empty($this->_union))
		{
			$union = implode(' ', $this->_union);
			$query = "($query) $union ";
		}
		if (func_num_args())
		{
			switch (func_get_arg(0))
			{
				case self::SUBQUERY:
					return "($query)";
			}
		}
		return $query;
	}

	public function getParams()
	{
		return $this->_param;
	}

	/** @return DB_Result */
	public function execute()
	{
		return DB::get_connect()->query($this->getQuery(), $this->getParams());
	}

}
