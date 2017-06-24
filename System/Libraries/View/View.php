<?php

namespace System\Libraries\View;

class View
{

	/** @var self */
	protected static $instance = null;

	/** @var Page */
	protected $page = null;

	public static function init()
	{
		$obj = new self();
		$obj->page = new Page();
		self::$instance = $obj;
	}

	public static function __callStatic($name, $arguments)
	{
		return call_user_func_array([self::$instance->page, $name], $arguments);
	}

}
