<?php

namespace System\Libraries\Router;

class Route
{

	/**
	 * Constants for before and after filters
	 */
	const BEFORE = 'before';
	const AFTER = 'after';
	const PREFIX = 'prefix';

	/**
	 * Constants for common HTTP methods
	 */
	const ANY = 'ANY';
	const GET = 'GET';
	const HEAD = 'HEAD';
	const POST = 'POST';
	const PUT = 'PUT';
	const PATCH = 'PATCH';
	const DELETE = 'DELETE';
	const OPTIONS = 'OPTIONS';

	public static $routes = array();

	public static function __callStatic($name, $arguments)
	{
		array_push(self::$routes, array_merge(array(strtoupper($name)), $arguments));
	}

}
