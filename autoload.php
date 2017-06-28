<?php

spl_autoload_register(function($class) {

	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');
	if (file_exists($class))
	{
		require_once $class;
	}
	else
	{
		return false;
	}
});
