<?php

namespace System\Core;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Http\Messages\Response;
use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\View\View;
use System\Libraries\Database\SQL;
use System\Libraries\Router\Exception\HttpRouteNotFoundException;
use Exception;

class App
{

	/**
	 * Run Application
	 */
	public static function run()
	{
		try
		{
			$container = new Container();
			$request = $container->request = Request::createFromGlobals($_SERVER);
			$response = $container->response = new Response();
			$view = $container->view = (new View())->setTemplateDir('App/Views');

			Config::$route = new RouteCollector();
			SQL::$database = &Config::$database;

			require 'App/Config/Route.php';
			require 'App/Config/Database.php';

			$dispatcher = new Dispatcher(
					Config::$route->getData(), new Handler($container, '\\App\\Controllers')
			);


			if (($data = $dispatcher->dispatch(
					$request->getMethod(), $request->getUri()->getPath()
					)) instanceof Response)
			{
				$response = $data;
			}
			else
			{
				$response->write($view->getContent());
			}
		}
		catch (HttpRouteNotFoundException $e)
		{
			$response = $response->withStatus(404);
			$response->write($view->set('error/404')->render());
		}
		catch (Exception $e)
		{
			$view->set('error/exception')['e'] = $e;
			$response->write($view->render());
		}

		self::send($response);
	}

	/**
	 * 
	 * @param Response $response
	 * @return void
	 */
	protected static function send(Response $response)
	{
		// STATUS CODE
		http_response_code($response->getStatusCode());

		// Headers
		foreach ($response->getHeaders() as $name => $values)
		{
			foreach ($values as $value)
			{
				header("{$name}: {$value}", false);
			}
		}

		// content
		echo $response->getBody();
		return;
	}

}
