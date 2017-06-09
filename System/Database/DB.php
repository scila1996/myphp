<?php

namespace System\Database;

class DB
{

	/** @var array */
	public static $config = array();

	/** @var self */
	private static $instance = null;

	/** @var Pdo */
	private $connect = null;

	private function __construct()
	{
		// default config //
		$config = array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => 'root',
			'password' => '',
			'db' => '',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci'
		);
		$config = array_merge($config, self::$config);
		$this->connect = new Pdo($config["driver"], $config["host"], $config["port"], $config["user"], $config["password"], $config["db"], $config["charset"], $config["collation"]);
	}

	/** @return self */
	public static function getConnect()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance->connect;
	}

	public static function begin()
	{
		return DB::getConnect()->begin();
	}

	public static function commit()
	{
		return DB::getConnect()->commit();
	}

	public static function rollback()
	{
		return DB::getConnect()->rollback();
	}

	public static function query($query = '', $param = null)
	{
		return new Query($query, $param);
	}

}
