<?php

namespace System\Core;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Http\Messages\Response;
use System\Libraries\Router\RouteCollector;
use System\Libraries\Router\Dispatcher;
use System\Libraries\View\View;
use System\Libraries\Database\DB;
use System\Libraries\Router\Exception\HttpRouteNotFoundException;
use Exception;

class App
{

    /** @var array */
    public static $namespace = [
        'controller' => '\\App\\Controllers'
    ];

    /** @var array */
    public static $path = [
        'view' => 'App/Views'
    ];

    /** @var array */
    public static $config = [
        'route' => 'App/Config/Route.php',
        'database' => 'App/Config/Database.php'
    ];

    /**
     * Run Application
     * 
     * @return void
     */
    public static function run()
    {
        try
        {
            $container = new Container();
            $request = $container->request = Request::createFromGlobals($_SERVER);
            $response = $container->response = new Response();
            $view = $container->view = (new View())->setTemplateDir(self::$path['view']);

            Config::$route = new RouteCollector();
            DB::$database = &Config::$database;

            foreach (self::$config as $config)
            {
                require $config;
            }

            $handler = new Handler($container, self::$namespace['controller']);
            $dispatcher = new Dispatcher(Config::$route->getData(), $handler);
            $data = $dispatcher->dispatch(
                    $request->getMethod(), $request->getUri()->getPath()
            );

            if ($data instanceof Response)
            {
                $response = $data;
            }
            else
            {
                $response = $handler->controller->response;
                $response->write($data ? strval($data) : $handler->controller->view->getContent());
            }
        }
        catch (HttpRouteNotFoundException $e)
        {
            $response = $response->withStatus(404);
            $response->write($view->set('error/404')->render());
        }
        catch (Exception $e)
        {
            $view->setFileExtension('.php');
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
