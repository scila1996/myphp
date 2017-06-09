<?php

namespace System\Database\Interfaces;

interface QueryInterface
{

	CONST DESC = 'DESC';
	CONST ASC = 'ASC';
	CONST SUBQUERY = 1;

	/**
	 * 
	 * @param string|array $column
	 * @return self
	 */
	public function select($column = '*');

	/**
	 * 
	 * @param string $table
	 * @param string $alias optional
	 * @return self
	 */
	public function from($table, $alias = '');

	/**
	 * 
	 * @param string $column
	 * @param mixed $value
	 */
	public function where($data);

	/**
	 * 
	 * @param string $column
	 * @param mixed $value
	 */
	public function orWhere($data);

	/**
	 * 
	 * @param string $column
	 */
	public function whereIsNull($column);

	/**
	 * 
	 * @param string $column
	 */
	public function whereNotNull($column);

	/**
	 * 
	 * @param string $column
	 * @param array $data
	 */
	public function whereIn($column, $data);

	/**
	 * 
	 * @param string $column
	 * @param array $data
	 */
	public function whereNotIn($column, $data);

	/**
	 * 
	 * @param string $column
	 * @param array $data
	 */
	public function whereBetween($column, $data);

	/**
	 * 
	 * @param string $column
	 * @param array $data
	 */
	public function whereNotBetween($column, $data);

	/**
	 * 
	 * @param self $query
	 */
	public function whereExists($query);

	/**
	 * 
	 * @param self $query
	 */
	public function whereNotExists($query);

	/**
	 * 
	 * @param string $condition
	 * @param array $param optional
	 */
	public function whereRaw($condition, $param = array());

	/**
	 * 
	 * @param self $query
	 */
	public function union($query);

	/**
	 * 
	 * @param self $query
	 */
	public function unionAll($query);

	/**
	 * 
	 * @param string $column
	 */
	public function groupBy($column);

	/**
	 * 
	 * @param string $column
	 * @param mixed $value
	 */
	public function having($data);

	/**
	 * 
	 * @param string $condition
	 * @param array $param optional
	 */
	public function havingRaw($condition, $param = array());

	/**
	 * 
	 * @param string $column
	 * @param string $sort
	 */
	public function orderBy($column, $sort = self::DESC);

	/**
	 * 
	 * @param string $table
	 * @param array $data
	 */
	public function insert($table, array $data);

	/**
	 * 
	 * @param string $table
	 * @param string $alias
	 */
	public function update($table, $alias = '');

	/**
	 * 
	 * @param string $table
	 */
	public function delete($table = '');

	/**
	 * 
	 * @param array $data
	 */
	public function set($data);

	/**
	 * 
	 * @param string $table
	 */
	public function join($table);

	/**
	 * 
	 * @param string $table
	 */
	public function innerJoin($table);

	/**
	 * 
	 * @param string $table
	 */
	public function leftJoin($table);

	/**
	 * 
	 * @param string $table
	 */
	public function rightJoin($table);

	/**
	 * 
	 * @param integer $n
	 * @param integer $offset optional
	 */
	public function limit($n, $offset = 0);

	/**
	 * 
	 * @param integer $n
	 */
	public function offset($n);

	/**
	 * @return string
	 */
	public function getQuery();

	/**
	 * @return array
	 */
	public function getParams();

	/**
	 * @return integer|\Traversable
	 */
	public function execute();

	/**
	 * @return string
	 */
	public function __toString();
}
