<?php

use System\Core\Config;

Config::$route->get('/', ["App\\Controllers\\Home", "index"]);
Config::$route->get("/get/{id}", ["App\\Controllers\\Home", "index"]);

Config::$route->get('/sqlsrv', ["App\\Controllers\\Home", "sqlsrv"]);
Config::$route->get("/mysql", ["App\\Controllers\\Home", "mysql"]);
