<?php

use System\Core\Config;
use System\Libraries\Router\RouteCollector;

Config::$route->get('/test', ["TestCtrl", "index"]);

Config::$route->filter('login', ["MiddleWare", "validLogin"]);
Config::$route->filter('auth', ["MiddleWare", "requireLogin"]);

// Route for login page
Config::$route->group(['before' => 'login'], function (RouteCollector $router) {
	$router->get('/login', ["LoginCtrl", "index"]);
	$router->post('/login', ["LoginCtrl", "submitForm"]);
});

Config::$route->group(['before' => 'auth'], function (RouteCollector $router) {

	// Home
	$router->any('/', ["HomeCtrl", "index"]);

	// Lands
	$router->any('/view/lands', ["HomeCtrl", "viewArticle"]);
	$router->any('/ajax/lands', ["HomeCtrl", "ajaxTable"]);

	// Members
	$router->any('/view/members', ["HomeCtrl", "viewMembers"]);

	// Update
	$router->get('/update', ["HomeCtrl", "updateArticle"]);
	$router->post('/update', ["HomeCtrl", "processUpdateArticle"]);

	$router->get('/update/count', ["HomeCtrl", "countArticleByDay"]);

	$router->any('/logout', ["HomeCtrl", "logout"]);
});
