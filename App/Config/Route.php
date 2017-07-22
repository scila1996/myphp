<?php

use System\Core\Config;
use System\Libraries\Router\RouteCollector;

Config::$route->filter('login', ["App\\Controllers\\Middle", "validLogin"]);
Config::$route->filter('auth', ["App\\Controllers\\Middle", "requireLogin"]);

// Route for login page
Config::$route->group(['before' => 'login'], function (RouteCollector $router) {
	Config::$route->get('/login', ["App\\Controllers\\LoginCtrl", "index"]);
	Config::$route->post('/login', ["App\\Controllers\\LoginCtrl", "submitForm"]);
});

Config::$route->group(['before' => 'auth'], function (RouteCollector $router) {

	$router->any('/', ["App\\Controllers\\Home", "index"]);

	$router->any('/view/table', ["App\\Controllers\\Home", "viewArticle"]);
	$router->any('/ajax/table', ["App\\Controllers\\Home", "ajaxTable"]);

	$router->get('/update', ["App\\Controllers\\Home", "updateArticle"]);
	$router->post('/update', ["App\\Controllers\\Home", "processUpdateArticle"]);

	$router->get('/update/count', ["App\\Controllers\\Home", "countArticleByDay"]);

	$router->any('/logout', ["App\\Controllers\\Home", "logout"]);
});
