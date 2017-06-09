<?php

namespace System\Libraries\Routing;

use System\Libraries\Http\Request;

class Route
{

	const GET = "GET";
	const POST = "POST";
	const PUT = "PUT";
	const DELETE = "DELETE";

	/** @var Route[] */
	private static $oRoutes = array();

	/** @var \System\Libraries\Http\Interfaces\ServerRequestInterface */
	private static $oRequest = null;

	/** @var string */
	private static $routePath = "";

	/** @var string */
	private $pattern = null;

	/** @var string|\Closure */
	private $handler = null;

	/** @var MiddleWare */
	private $middleware = null;

	/** @var array */
	private $params = array();

	/** @var array */
	private $where = array();

	private static function getRoutePath()
	{
		$path = str_replace($_SERVER["SCRIPT_NAME"], "", self::$oRequest->getUri()->getPath());
		return $path === "" ? "/" : preg_replace("/\/{2,}/", "/", $path);
	}

	public static function getRequest()
	{
		self::$oRequest = Request::createFromGlobals($_SERVER);
		self::$routePath = self::getRoutePath();
		return self::$oRequest;
	}

	/** @return self */
	public static function add($method, $routePattern, $handler, MiddleWare $middleware = null)
	{
		if ($method === TRUE)
		{
			$method = array(
				self::GET, self::POST, self::PUT, self::DELETE
			);
		}
		if (!is_array($method))
		{
			$method = array($method);
		}
		if (in_array(self::$oRequest->getMethod(), $method))
		{
			$objRet = new self($routePattern, $handler);
			if ($middleware instanceof MiddleWare)
			{
				$objRet->middleware($middleware);
			}
			array_push(self::$oRoutes, $objRet);
			return $objRet;
		}
		return FALSE;
	}

	/** @return self */
	public static function get()
	{
		return call_user_func_array("self::add", array_merge(array(self::GET), func_get_args()));
	}

	/** @return self */
	public static function post()
	{
		return call_user_func_array("self::add", array_merge(array(self::POST), func_get_args()));
	}

	/** @return self */
	public static function put()
	{
		return call_user_func_array("self::add", array_merge(array(self::PUT), func_get_args()));
	}

	/** @return self */
	public static function delete()
	{
		return call_user_func_array("self::add", array_merge(array(self::DELETE), func_get_args()));
	}

	/** @return self */
	public static function match()
	{
		return call_user_func_array("self::add", array_merge(array(TRUE), func_get_args()));
	}

	private function __construct($routePattern, $handler)
	{
		$this->pattern = $routePattern;
		$this->handler = $handler;
	}

	/** @return boolean */
	private function parser()
	{
		$matches = array();
		$where = $this->where;
		$regex = preg_replace_callback('#\{(\w+)\}#', function($matches) use ($where) {
			if (array_key_exists($matches[1], $where))
			{
				return "({$where[$matches[1]]})";
			}
			else
			{
				return '([^/]+)';
			}
		}, $this->pattern);
		if (preg_match("|^{$regex}$|i", self::$routePath, $matches))
		{
			if (count($matches) >= 2)
			{
				$this->params = array_slice($matches, 1);
			}
			return TRUE;
		}
		return FALSE;
	}

	/** @return \Closure|void */
	public function handler($handler = null)
	{
		if (func_num_args() === 0)
		{
			return $this->handler;
		}
		$this->handler = $handler;
	}

	/** @return MiddleWare|void */
	public function middleware(MiddleWare $middleware = null)
	{
		if (func_num_args() === 0)
		{
			return $this->middleware;
		}
		$this->middleware = $middleware;
	}

	/** @return array */
	public function params()
	{
		return $this->params;
	}

	public function where($name, $pattern)
	{
		if (is_array($name))
		{
			$this->where = array_merge($this->where, $name);
		}
		else
		{
			$this->where[$name] = $pattern;
		}
	}

	/** @return self */
	public static function validate()
	{
		foreach (self::$oRoutes as $route)
		{
			if ($route->parser())
			{
				return $route;
			}
		}
		throw new NotFoundException("Not Found");
	}

}
