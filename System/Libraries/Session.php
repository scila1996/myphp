<?php

namespace System\Libraries;

class Session
{

	CONST KEY = '__app__';

	public static function start()
	{
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();
			if (!isset($_SESSION[self::KEY]))
			{
				$_SESSION[self::KEY] = array();
			}
		}
	}

	public static function destroy()
	{
		if (session_status() == PHP_SESSION_ACTIVE)
		{
			session_destroy();
		}
	}

	public static function set($key, $value)
	{
		self::start();
		if (!$key)
		{
			throw new Exception\Session_InvalidKey('The "key" is invalid !', 16);
		}
		$_SESSION[self::KEY][$key] = $value;
	}

	public static function has($key)
	{
		self::start();
		return isset($_SESSION[self::KEY][$key]);
	}

	public static function get($key)
	{
		self::start();
		return self::has($key) ? $_SESSION[self::KEY][$key] : null;
	}

	public static function remove($key)
	{
		self::start();
		unset($_SESSION[self::KEY][$key]);
	}

	public static function get_key()
	{
		return session_id();
	}

}
