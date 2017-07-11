<?php

namespace System\Core;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Http\Messages\Response;
use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\View\View;
use System\Libraries\Database\SQL;

class App
{

	public static function start()
	{
		Config::$route = new RouteCollector();

		require 'App/Config/Route.php';
		require 'App/Config/Database.php';

		SQL::$database = Config::$database;

		$container = new Container([
			'request' => Request::createFromGlobals($_SERVER),
			'response' => new Response(),
			'view' => (new View())->setTemplateDir('App/Views')
		]);

		$handler = new Handler($container);
		$outstream = null;
		$dispatcher = new Dispatcher(Config::$route->getData(), $handler);
		$ret = $dispatcher->dispatch($container['request']->getMethod(), $container['request']->getUri()->getPath());
		$handler->getController()->__process();

		if ($ret instanceof Response)
		{
			$outstream = $ret->getBody();
		}
		else
		{
			$outstream = $handler->getController()->view->getContent();
		}

		echo $outstream;
	}

}
