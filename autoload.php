<?php

spl_autoload_register(function($class) {
	if (strpos($class, 'Twig_') !== false)
	{
		$file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
		if (file_exists($file))
		{
			require $file;
		}
	}
	else
	{
		$class = str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');
		if (file_exists($class))
		{
			require_once $class;
		}
		else
		{
			return false;
		}
	}
});
