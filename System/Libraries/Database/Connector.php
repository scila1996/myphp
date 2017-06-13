<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\DatabaseInterface;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Database\Query\Grammars\MySqlGrammar;
use System\Libraries\Database\Query\Grammars\SqlServerGrammar;
use System\Libraries\Database\Query\Grammars\PostgresGrammar;
use System\Libraries\Database\Query\Grammars\SQLiteGrammar;
use PDO;

class Connector implements DatabaseInterface
{

	/** @var PDO PDO Object */
	private $pdo = null;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
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
				switch ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
				{
					case self::MYSQL:
						$rows = $this->pdo->query("SELECT FOUND_ROWS() AS rows")->fetchObject()->rows;
						return new Collection($stmt, $rows);
					default:
						return new Collection($stmt);
				}
			}
			else
			{
				return $result;
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
			case self::ODBC:
				return new Builder(new SqlServerGrammar());
			case self::SQLITE:
				return new Builder(new SQLiteGrammar());
			case self::PGSQL:
				return new Builder(new PostgresGrammar());
		}
		return new Builder();
	}

}
