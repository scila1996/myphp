<?php

namespace System\Libraries\View;

class View
{

	/** @var string */
	protected static $dir = '.';

	/** @var string */
	protected static $fileExt = '.php';

	/**
	 * 
	 * @param string $directory
	 * @return void
	 */
	public static function setTemplateDir($directory)
	{
		self::$dir = $directory;
	}

	/**
	 * 
	 * @param string $extension
	 */
	public static function setFileExtension($extension)
	{
		self::$fileExt = $extension;
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return Template
	 */
	public static function load($file, $data = [])
	{
		$file = self::$dir . DIRECTORY_SEPARATOR . $file . self::$fileExt;
		return new Template($file, $data);
	}

}
