<?php

ini_set('display_errors', '1');
set_error_handler(function($severity, $message, $file, $line) {
	throw new ErrorException($message, $severity, $severity, $file, $line);
});

require_once 'autoload.php';

use System\Libraries\Routing\Route;
use System\Libraries\Routing\MiddleWare;
use System\Libraries\Routing\NotFoundException;
use System\Libraries\View;

$root = $_SERVER["DOCUMENT_ROOT"];
View::$path = "{$root}/App/View";
$ControllerNamespace = "\\App\\Controller";

try
{
	$RequestObject = Route::getRequest();
	require("{$root}//App//Config//routes.php");
	$RouteObject = Route::validate();
	$MiddleWare = $RouteObject->middleware();
	$Handler = $RouteObject->handler();

	if ($MiddleWare instanceof MiddleWare)
	{
		$MiddleWare($RequestObject);
	}

	if ($MiddleWare instanceof \Closure)
	{
		$Handler();
	}
	else if (is_string($Handler))
	{
		$parts = explode("::", $Handler);
		$ControllerClass = "{$ControllerNamespace}\\{$parts[0]}";
		$ControllerMethod = $parts[1];
		$ControllerObject = new $ControllerClass($RequestObject);
		call_user_func_array(array($ControllerObject, $ControllerMethod), $RouteObject->params());
		$ControllerObject();
	}
}
catch (NotFoundException $e)
{
	http_response_code(404);
	try
	{
		echo View::get("error/404.php");
	}
	catch (\Exception $e)
	{
		var_dump("<pre> $e </pre>");
	}
	exit;
}
catch (\Exception $e)
{
	http_response_code(500);
	$error = ob_get_contents();
	ob_clean();
	try
	{
		echo View::get("error/exception.php", array(
			"e" => $e,
			"error" => $error
		));
	}
	catch (\Exception $e)
	{
		var_dump("<pre> $e </pre>");
	}
	exit;
}