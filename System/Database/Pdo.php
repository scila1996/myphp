<?php

namespace System\Database;

use System\Database\Interfaces\DatabaseInterface;

class Pdo extends \PDO implements DatabaseInterface
{

	private $driver = "";
	private $database = "";

	public function __construct($driver, $host, $port, $user, $password, $db, $charset = null, $collation = null)
	{

		$this->driver = $driver;
		$this->database = $db;

		$dsn = "{$driver}:";

		switch ($driver)
		{
			case 'sqlsrv':
				$dsn .= "Server={$host},{$port};Database={$db}";
				break;
			default:
				$dsn .= "host={$host};port={$port};dbname={$db}";
				if ($charset)
				{
					$dsn .= ";charset={$charset}";
				}
		}

		parent::__construct($dsn, $user, $password, array(self::ATTR_ERRMODE => self::ERRMODE_EXCEPTION));

		if ($collation)
		{
			switch ($driver)
			{
				case 'mysql':
					parent::query("SET collation_connection = {$collation}");
					break;
			}
		}
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

	/** @return Interfaces\CollectionInterface */
	public function query($str, $param = NULL)
	{
		$stmt = parent::prepare($str);
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
				switch ($this->driver)
				{
					case "mysql":
						$rows = $this->rawQuery("SELECT FOUND_ROWS() AS rows")->fetchObject()->rows;
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

	/** @return \PDOStatement */
	public function rawQuery()
	{
		return call_user_func_array(array($this, 'parent::query'), func_get_args());
	}

}
