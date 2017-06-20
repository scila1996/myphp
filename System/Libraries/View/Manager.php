<?php

namespace System\Libraries\View;

class Manager
{

	/** @var string */
	private static $sPath = '';

	/** @var Layout[] */
	private static $LayOuts = [];

	/**
	 * @param string $path
	 * @return void
	 */
	public static function setViewPath($path)
	{
		self::$sPath = $path;
	}

	/**
	 * 
	 * @return string
	 */
	public static function getViewPath()
	{
		return self::$sPath;
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return Layout
	 */
	public static function add($file, $data = array())
	{
		$layout = new Layout(preg_replace('/\/{2,}/', '/', self::$sPath . '/' . $file), $data);
		self::$LayOuts[] = $layout;
		return $layout;
	}

	/**
	 * @return string
	 */
	public static function render()
	{
		$text = '';
		foreach (self::$LayOuts as $view)
		{
			$text = "{$text}{$view}";
		}
	}

}
