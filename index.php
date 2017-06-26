<?php

ini_set('display_errors', '1');
ini_set('short_open_tag', '1');

set_error_handler(function($severity, $message, $file, $line) {
	throw new ErrorException($message, $severity, $severity, $file, $line);
});

require_once 'autoload.php';

use System\Libraries\Http\Messages\Request;
use System\Libraries\Http\Messages\Response;
use System\Libraries\Router\Route;
use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\Router\Exception\HttpRouteNotFoundException;

$loader = new System_Libraries_Twig_Loader_Filesystem('App/Views');
$twig = new System_Libraries_Twig_Environment($loader);
$template = $twig->load('test.php');
echo $template->render(['pow' => pow(2, 16)]);

exit;

function getRequest()
{
	$r = Request::createFromGlobals($_SERVER);
	return $r->withUri($r->getUri()->withPath(str_replace($r->getServerParam("SCRIPT_NAME"), "", $r->getUri()->getPath())));
}

function view($file, $data = [])
{
	return View::addTemplate($file, $data);
}

try
{
	require '/App/Config/Route.php';
	require '/App/Config/Database.php';

	View::init();
	View::setTemplateDir('App\Views');

	$ControllerNamespace = "\\App\\Controllers";
	$RequestObject = getRequest();
	$ResponseObject = new Response();
	$Router = new RouteCollector();

	foreach (Route::$routes as $params)
	{
		list($httpMethod, $routePattern, $handlerCallback) = $params;
		list($class, $method) = array_replace(array("", "index"), explode("::", "{$ControllerNamespace}\\{$handlerCallback}"));
		$handlerCallback = function() use ($RequestObject, $ResponseObject, $class, $method) {
			$Obj = new $class($RequestObject, $ResponseObject);
			call_user_func_array(array($Obj, $method), func_get_args());
			$Obj();
		};
		$Router->addRoute($httpMethod, $routePattern, $handlerCallback);
	}

	$dispatcher = (new Dispatcher($Router->getData()));
	$dispatcher->dispatch($RequestObject->getMethod(), $RequestObject->getUri()->getPath());
}
catch (HttpRouteNotFoundException $e)
{
	$hcode = "{$RequestObject->getServerParam("SERVER_PROTOCOL")} 404 Not Found";
	header($hcode);
	echo <<<EOF
<!DOCTYPE HTML>
<html>
	<head>
		<title> 404 </title>
	</head>
<body>
	<p> $hcode </p>
</body>
</html>
EOF;
	exit;
}
catch (\Exception $e)
{
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