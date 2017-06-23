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

	/** @var PDO PDO Object */
	private $pdo = null;
	private $driver = "";

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		$this->driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
	}

	/** @return boolean */
	public function begin()
	{
		return $this->pdo->beginTransaction();
	}

	/** @return boolean */
	public function commit()
	{
		return $this->pdo->commit();
	}

	/** @return boolean */
	public function rollback()
	{
		return $this->pdo->rollBack();
	}

	/** @return Interfaces\CollectionInterface */
	public function query($str, $param = NULL)
	{
		if ($this->driver == self::MYSQL)
		{
			$str = preg_replace("/^\s*(\(?\s*select)/i", "$1 sql_calc_found_rows", $str, 1);
		}
		$stmt = $this->pdo->prepare($str);
		if ($stmt)
		{
			if (is_array($param))
			{
				foreach (array_keys($param) as $p => $key)
				{
					$stmt->bindParam($p + 1, $param[$key]);
				}
			}
			$result = $stmt->execute();
			if ($stmt->columnCount())
			{
				if ($this->driver == self::MYSQL and $this->pdo->getAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY))
				{
					$rows = $this->pdo->query("select found_rows() as rows")->fetchObject()->rows;
					return new Collection($stmt, $rows);
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

}
