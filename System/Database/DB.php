<?php

namespace System\Database;

use System\Common\Config;
use System\Database\DB_Query;

class DB
{

	public static $auto_open_connect = TRUE;
	private static $instance = NULL;
	public static $db_driver = 'read from config file';
	private $connect = NULL;

	private function __construct()
	{
		$config = array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'db' => ''
		); // -> default config
		$db = array_merge($config, Config::get('db'));
		self::$db_driver = $db['driver'];
		$this->connect = new PDO\Sql($db);
	}

	public static function open($new_connect = FALSE)
	{
		if (self::$instance instanceof self and $new_connect === FALSE)
		{
			return FALSE;
		}
		else
		{
			self::$instance = new self();
			return TRUE;
		}
	}

	public static function begin()
	{
		return DB::get_connect()->begin();
	}

	public static function commit()
	{
		return DB::get_connect()->commit();
	}

	public static function rollback()
	{
		return DB::get_connect()->rollback();
	}

	public static function query($query = '', $param = NULL)
	{
		return new DB_Query($query, $param);
	}

	/** get data from quickly 'SELECT * FROM ...' clause */
	public static function get($table)
	{
		return self::query()->table($table)->execute();
	}

	public static function close()
	{
		if (method_exists(self::$instance->connect, 'close'))
		{
			$r = self::$instance->connect->close();
			self::$instance = NULL;
		}
		return FALSE;
	}

	/** @return DB_ISQL */
	public static function get_connect()
	{
		DB::open();
		return self::$instance->connect;
	}

}
