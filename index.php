<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

set_error_handler(function($severity, $message, $file, $line) {
	throw new ErrorException($message, $severity, $severity, $file, $line);
});

require_once 'autoload.php';

use System\Libraries\Router\Exception\HttpRouteNotFoundException;
use System\Core\App;

try
{
	App::start();
}
catch (HttpRouteNotFoundException $e)
{
	$hcode = "{$_SERVER["SERVER_PROTOCOL"]} 404 Not Found";
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
catch (Exception $e)
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