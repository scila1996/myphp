<?php

namespace System\Database\PDO;

use System\Database\DB;
use System\Database\DB_Result;
use System\Database\DB_Exception;
use System\Database\DB_ISQL;

class Sql extends \PDO implements DB_ISQL
{

	private $pdo_stmt = NULL;
	private $n_affected_rows = FALSE;

	public function __construct($db)
	{
		$dsn = $db['driver'] . ':';
		switch ($db['driver'])
		{
			case 'sqlsrv':
				$dsn .= "Server={$db['host']},{$db['port']};Database={$db['db']}";
				break;
			default:
				$dsn .= "host={$db['host']};port={$db['port']};dbname={$db['db']};charset={$db['charset']}";
		}

		parent::__construct($dsn, $db['user'], $db['password'], array(self::ATTR_ERRMODE => self::ERRMODE_EXCEPTION));

		if ($db['collation'])
		{
			switch ($db['driver'])
			{
				case 'mysql':
					parent::query("SET collation_connection = {$db['collation']}");
					break;
			}
		}
	}

	public function raw_query()
	{
		if (($r = call_user_func_array(array($this, 'parent::query'), func_get_args())))
		{
			return $r;
		}
		$arr_err = $this->errorInfo();
		throw new DB_Exception($arr_err[2], $arr_err[1]);
	}

	/**
	 * get result from stmt . Return DB_Result or TRUE
	 * @return mixed
	 */
	private function _get_result_from_stmt()
	{
		if ($this->pdo_stmt->columnCount())
		{
			$num_rows = $this->pdo_stmt->rowCount();
			switch (DB::$db_driver)
			{
				case 'mysql': {
						if (preg_match('/^\s*\(*SELECT/i', $this->pdo_stmt->queryString)) // ONLY for SELECT QUERY
						{
							$num_rows = $this->raw_query('SELECT FOUND_ROWS() AS total')->fetchObject()->total;
						}
						break;
					}
			}
			return new Result($this->pdo_stmt, $num_rows);
		}
		return TRUE;
	}

	public function begin()
	{
		return parent::beginTransaction();
	}

	public function commit()
	{
		return parent::commit();
	}

	public function rollback()
	{
		return parent::rollBack();
	}

	public function query($query_str, $param = NULL)
	{
		if (!($this->pdo_stmt = parent::prepare($query_str)))
		{
			$arr_err = $this->errorInfo();
			throw new DB_Exception($arr_err[2], $arr_err[1]);
		}
		if (is_array($param))
		{
			foreach (array_keys($param) as $p => $key)
			{
				if (!$this->pdo_stmt->bindParam($p + 1, $param[$key]))
				{
					$arr_err = $this->errorInfo();
					throw new DB_Exception($arr_err[2], $arr_err[1]);
				}
			}
		}
		if (!$this->pdo_stmt->execute())
		{
			$arr_err = $this->errorInfo();
			throw new DB_Exception($arr_err[2], $arr_err[1]);
		}
		if (($r = $this->_get_result_from_stmt()) instanceof DB_Result)
		{
			return $r;
		}
		$this->n_affected_rows = $this->pdo_stmt->rowCount();
		return $this->get_affected_rows();
	}

	public function get_affected_rows()
	{
		return $this->n_affected_rows;
	}

	// MYSQL
	public function setBufferedQuery($f = TRUE)
	{
		$this->setAttribute(self::MYSQL_ATTR_USE_BUFFERED_QUERY, $f);
	}

}
