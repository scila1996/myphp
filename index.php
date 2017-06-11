<?php

ini_set('display_errors', '1');
set_error_handler(function($severity, $message, $file, $line) {
	throw new ErrorException($message, $severity, $severity, $file, $line);
});

require_once 'autoload.php';

use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\Router\Exception\HttpRouteNotFoundException;
use System\Libraries\Router\Exception\BadRouteException;
use System\Libraries\Http\Request;
use System\Libraries\View;
use System\Config\Route;

function getRequest()
{
	$r = Request::createFromGlobals($_SERVER);
	return $r->withUri($r->getUri()->withPath(str_replace($r->getServerParam("SCRIPT_NAME"), "", $r->getUri()->getPath())));
}

try
{
	require '/App/Config/Route.php';
	require '/App/Config/Database.php';
	View::$path = "App/View";
	$ControllerNamespace = "\\App\\Controller";

	$RequestObject = getRequest();
	$router = new RouteCollector();

	foreach (Route::$routes as $params)
	{
		$controller = explode("::", "{$ControllerNamespace}\\{$params[2]}");
		if (count($controller) == 2)
		{
			$class = $controller[0];
			if (!class_exists($class))
			{
				throw new BadRouteException("Controller NOT FOUND !");
			}
			$method = $controller[1];
			$router->addRoute($params[0], $params[1], function() use ($class, $method, $RequestObject) {
				$obj = new $class($RequestObject);
				if (!method_exists($obj, $method))
				{
					throw new BadRouteException("Method in Controller NOT FOUND !");
				}
				call_user_func_array(array($obj, $method), func_get_args());
				$obj();
			});
		}
	}

	$dispatcher = (new Dispatcher($router->getData()));
	$dispatcher->dispatch($RequestObject->getMethod(), $RequestObject->getUri()->getPath());
}
catch (HttpRouteNotFoundException $e)
{
	http_response_code(404);
	echo <<<EOF
<!DOCTYPE HTML>
<html>
	<head>
		<title> 404 </title>
	</head>
<body>
	<p> 404 Not Found </p>
</body>
</html>
EOF;
	exit;
}
catch (\Exception $e)
{
	http_response_code(500);
	$exception = get_class($e);
	$time = date("F j, Y, g:i a");
	echo <<<EOF
<!DOCTYPE HTML>
<html>
	<head>
		<title> Error </title>
	</head>
	<body>
		<div>
			<h4> Exception : <span style="color: #048CAD"> {$exception} </span></h4>
			<hr />
			<table>
				<tbody>
					<tr><td><b> Message </b></td><td> {$e->getMessage()} </td></tr>
					<tr><td><b> Code </b></td><td> {$e->getCode()} </td></tr>
					<tr><td><b> File </b></td><td> {$e->getFile()} </td></tr>
					<tr><td><b> Line Number </b></td><td> {$e->getLine()} </td></tr>
				</tbody>
			</table>
			<hr />
			<pre>{$e->getTraceAsString()}</pre>
			<hr />
			<p><strong> Error Time</strong>: {$time} </p>
			<em> Please report this error to "Administrator" </em>
		</div>
	</body>
</html>
EOF;
	exit;
}