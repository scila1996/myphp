<?php

namespace System\Config;

class Route
{

	public static $routes = array();

	private static function add($httpMethod, $pattern, $handler)
	{
		array_push(self::$routes, func_get_args());
	}

	public static function get($pattern, $handler)
	{
		self::add("GET", $pattern, $handler);
	}

	public static function post($pattern, $handler)
	{
		self::add("POST", $pattern, $handler);
	}

	public static function put($pattern, $handler)
	{
		self::add("PUT", $pattern, $handler);
	}

	public static function delete($pattern, $handler)
	{
		self::add("DELETE", $pattern, $handler);
	}

	public static function head($pattern, $handler)
	{
		self::add("HEAD", $pattern, $handler);
	}

	public static function patch($pattern, $handler)
	{
		self::add("PATCH", $pattern, $handler);
	}

	public static function options($pattern, $handler)
	{
		self::add("OPTIONS", $pattern, $handler);
	}

	public static function any($pattern, $handler)
	{
		self::add("ANY", $pattern, $handler);
	}

}