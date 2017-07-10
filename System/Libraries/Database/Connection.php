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

	/** @var \PDO  */
	private $pdo = null;
	private $driver = "";

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		$this->driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
	}

	/**
	 * 
	 * @param Builder $query
	 * @return \System\Libraries\Database\Collection
	 */
	public function query(Builder $query)
	{
		$stmt = $this->runQuery($query->toSql(), $query->getBindings());
		if ($stmt->columnCount())
		{
			if ($this->driver == self::MYSQL && !$this->pdo->getAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY))
			{
				return new Collection($stmt);
			}
			else
			{
				$count = clone $query;
				return new Collection($stmt, $this->runQuery($count->offset(0)->count()->toSql(), $count->getBindings())->fetchObject()->aggregate);
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
