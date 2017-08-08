<?php

use System\Core\Config;
use System\Libraries\Router\RouteCollector;

Config::$route->get('/test', ["TestCtrl"]);

Config::$route->get('{:asset/[^\?]+}', ["HomeCtrl", "asset"]);

Config::$route->filter('login', ["MiddleWare", "validLogin"]);
Config::$route->filter('auth', ["MiddleWare", "requireLogin"]);

// Route for login page
Config::$route->group(['before' => 'login'], function (RouteCollector $router) {
    $router->get('/login', ["LoginCtrl", "index"]);
    $router->post('/login', ["LoginCtrl", "submitForm"]);
});

Config::$route->group(['before' => 'auth'], function (RouteCollector $router) {

    // Home
    $router->any('/', ["HomeCtrl"]);

    // Lands
    $router->any('/view/lands', ["HomeCtrl", "viewArticle"]);
    $router->get('/ajax/lands', ["HomeCtrl", "ajaxLands"]);

    // Members
    $router->any('/view/members', ["HomeCtrl", "viewMembers"]);
    $router->get('/ajax/members', ["HomeCtrl", "ajaxMembers"]);

    // Update
    $router->get('/update', ["HomeCtrl", "updateArticle"]);
    $router->post('/update', ["HomeCtrl", "processUpdateArticle"]);

    $router->any('/logout', ["LoginCtrl", "logout"]);
});
