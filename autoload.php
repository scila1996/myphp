<?php

spl_autoload_register(function($class) {
	$class = str_replace('\\', '/', $class . '.php');
	if (file_exists($class))
	{
		require_once $class;
	}
	else if (file_exists($file = (
					$_SERVER['DOCUMENT_ROOT'] . '/' .
					strtolower(dirname($class)) . '/' .
					basename($class)
			)))
	{
		require_once $file;
	}
	else
	{
		return false;
	}
});
