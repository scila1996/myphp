<?php

namespace System\Core;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Http\Messages\Response;
use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\View\View;
use System\Libraries\Database\SQL;
use System\Libraries\Router\HandlerResolverInterface;

class App implements HandlerResolverInterface
{

	/** @var Container */
	protected $container = null;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/** @return Controller */
	public function resolve($handler)
	{
		if (is_array($handler) && is_string($handler[0]))
		{
			$handler[0] = new $handler[0]();
			foreach ($this->container->getIterator() as $prop => $obj)
			{
				$handler[0]->{$prop} = $obj;
			}
		}

		return $handler;
	}

	public static function start()
	{
		Config::$route = new RouteCollector();

		require 'App/Config/Route.php';
		require 'App/Config/Database.php';

		SQL::$database = Config::$database;

		$container = new Container();
		$container['request'] = Request::createFromGlobals($_SERVER);
		$container['response'] = new Response();
		$container['view'] = (new View())->setTemplateDir('App/Views');

		$dispatcher = new Dispatcher(Config::$route->getData(), new static($container));
		$ret = $dispatcher->dispatch($container['request']->getMethod(), $container['request']->getUri()->getPath());
		$outstream = null;

		if ($ret instanceof Response)
		{
			$outstream = $ret->getBody();
		}
		else
		{
			$outstream = $container['view']->getContent();
		}

		echo $outstream;
	}

}
