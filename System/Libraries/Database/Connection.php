<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\DatabaseInterface;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Database\Query\Grammars\MySqlGrammar;
use System\Libraries\Database\Query\Grammars\SqlServerGrammar;
use System\Libraries\Database\Query\Grammars\PostgresGrammar;
use System\Libraries\Database\Query\Grammars\SQLiteGrammar;
use PDO;

class Connection implements DatabaseInterface
{

	/**
	 *
	 * @var PDO
	 */
	protected $pdo = null;

	/**
	 *
	 * @var string
	 */
	protected $driver = "";

	/**
	 * 
	 * @param PDO $pdo
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		$this->driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
	}

	/**
	 * 
	 * @param Builder $query
	 * @param integer $count
	 * @return \System\Libraries\Database\Collection
	 */
	public function query(Builder $query, $count = false)
	{
		$stmt = $this->runQuery($query->toSql(), $query->getBindings());

		if ($stmt->columnCount())
		{
			if ($count)
			{
				$count = clone $query;
				$count->count()->offset(null);
				return new Collection($stmt, $this->query($count, false)->first()->aggregate);
			}
			else
			{
				return new Collection($stmt);
			}
		}
		else
		{
			return $stmt->rowCount();
		}
	}

	/** @return $this->pdo */
	public function getPDO()
	{
		return $this->pdo;
	}

	/** @return Builder */
	public function getBuilder()
	{
		switch ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
		{
			case self::MYSQL:
				return new Builder(new MySqlGrammar());
			case self::SQLSRV:
				return new Builder(new SqlServerGrammar());
			case self::SQLITE:
				return new Builder(new SQLiteGrammar());
			case self::PGSQL:
				return new Builder(new PostgresGrammar());
		}
		return new Builder();
	}

	/**
	 * 
	 * @param string $str
	 * @param array $param
	 * @return \PDOStatement
	 */
	protected function runQuery($str, $param = null)
	{
		$stmt = $this->pdo->prepare($str);

		if (is_array($param))
		{
			foreach (array_keys($param) as $p => $key)
			{
				$stmt->bindParam($p + 1, $param[$key]);
			}
		}

		$stmt->execute();
		return $stmt;
	}

}
