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
		$response = $container['response'];
		$dispatcher = new Dispatcher(Config::$route->getData(), $handler);
		$ret = $dispatcher->dispatch($container['request']->getMethod(), $container['request']->getUri()->getPath());

		if ($ret instanceof Response)
		{
			$response = $ret;
		}
		else
		{
			$response->write($handler->getController()->view->getContent());
		}

		self::finish($response);
	}

	protected static function finish(Response $response)
	{
		// set Header
		foreach ($response->getHeaders() as $name => $values)
		{
			foreach ($values as $value)
			{
				header("{$name}: {$value}", false);
			}
		}
		// echo Response Content
		echo $response->getBody();
	}

}
