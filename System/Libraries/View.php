<?php

namespace System\Libraries;

class View
{

	private $_file = '';
	private $_data = array();
	public static $path = "";
	public static $data = array();
	private static $list = array();

	private function __construct($file, $data)
	{
		$this->_file = preg_replace('/\/{2,}/', '/', self::$path . '/' . $file);
		$this->_data = $data;
	}

	public static function add($file, $data = array())
	{
		array_push(self::$list, new self($file, $data));
	}

	public static function get($file, $data = array())
	{
		$obj = new self($file, $data);
		return $obj->getHtml();
	}

	public static function getAll()
	{
		$html = "";
		foreach (self::$list as $view)
		{
			$html .= $view->getHtml();
		}
		return $html;
	}

	public static function put(&$var)
	{
		echo $var;
	}

	public function getHtml()
	{
		ob_start();
		$dvars = array_merge(self::$data, $this->_data);
		if (is_array($dvars))
		{
			foreach (array_keys($dvars) as $var)
			{
				$$var = &$dvars[$var];
			}
		}
		eval('?>' . file_get_contents($this->_file));
		$__html_result = ob_get_contents();
		ob_end_clean();
		return preg_replace_callback('/(\{{2}\s*)(\w+)(\s*\}{2})/', function($m) use (&$dvars) {
			return isset($dvars[$m[2]]) ? $dvars[$m[2]] : NULL;
		}, $__html_result);
	}

}
