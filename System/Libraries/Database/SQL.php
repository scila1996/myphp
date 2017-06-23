<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Query\Builder;
use PDO;

class SQL
{

	public static $driver = Connection::MYSQL;
	public static $host = "localhost";
	public static $port = 3306;
	public static $user = "root";
	public static $password = "";
	public static $charset = "utf8";
	public static $collation = "utf8_unicode_ci";
	public static $db = "mysql";
	public static $file = null;
	public static $dsn = null;

	/** @var self */
	private static $instance = null;

	/** @var Connection */
	private $connect = null;

	public function __construct()
	{

		$dsn = self::$dsn;

		if ($dsn === null)
		{
			$dsn = sprintf("%s:", self::$driver);
			switch (self::$driver)
			{
				case Connection::MYSQL:
					$dsn .= sprintf("host=%s;port=%d;dbname=%s", self::$host, self::$port, self::$db);
					$dsn .= self::$charset ? sprintf(";charset=%s", self::$charset) : ";";
					break;
				case Connection::SQLSRV:
					$dsn .= sprintf("Server=%s,%d;Database=%s", self::$host, self::$port, self::$db);
					break;
				case Connection::SQLITE:
					$dsn .= self::$file;
					break;
				case Connection::PGSQL:
					$dsn .= sprintf("host=%s;port=%d;dbname=%s;user=%s;password=%s", self::$host, self::$port, self::$db, self::$user, self::$password);
					break;
			}
		}

		$pdo = new PDO($dsn, self::$user, self::$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		if (self::$driver === Connection::MYSQL and self::$collation)
		{
			$pdo->query(sprintf("SET collation_connection = %s", self::$collation));
		}

		$this->connect = new Connection($pdo);
	}

	/** @return self */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/** @return Connection */
	public static function getConnect()
	{
		return self::getInstance()->connect;
	}

	/** @return integer */
	public static function begin()
	{
		return self::getConnect()->begin();
	}

	/** @return integer */
	public static function commit()
	{
		return self::getConnect()->commit();
	}

	/** @return integer */
	public static function rollback()
	{
		return self::getConnect()->rollback();
	}

	/** @return \System\Libraries\Database\Query\Builder */
	public static function query()
	{
		return self::getConnect()->getBuilder();
	}

	/** @return integer|\System\Libraries\Database\Collection */
	public static function execute(Builder $query)
	{
		return self::getConnect()->query(strval($query), $query->getBindings());
	}

}
