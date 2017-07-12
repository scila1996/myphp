<?php

use System\Core\Config;

Config::$route->filter('login', ["App\\Controllers\\Middle", "validate"]);
// Route for login page
Config::$route->get('/login', ["App\\Controllers\\LoginCtrl", "index"], ['before' => 'login']);

Config::$route->any('/', ["App\\Controllers\\Home", "index"]);
Config::$route->any('/view/{:customer}', ["App\\Controllers\\Home", "viewArticle"]);
Config::$route->any('/view/{:cms}', ["App\\Controllers\\Home", "viewArticle"]);

Config::$route->get('/update', ["App\\Controllers\\Home", "updateArticle"]);
Config::$route->post('/update', ["App\\Controllers\\Home", "processUpdateArticle"]);

Config::$route->get('/update/count', ["App\\Controllers\\Home", "countArticleByDay"]);
