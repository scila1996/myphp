<?php

namespace System\Database;

use System\Database\Interfaces\DatabaseInterface;

class Pdo extends \PDO implements DatabaseInterface
{

	private
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
			$count = $stmt->columnCount();
			if ($count)
			{
				
			}
		}
	}

	public function rawQuery()
	{
		
	}

}
