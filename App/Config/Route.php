<?php

use System\Core\Config;

Config::$route->any('/', ["App\\Controllers\\Home", "index"]);
Config::$route->get("/get/{id}", ["App\\Controllers\\Home", "index"]);

Config::$route->get('/table', ["App\\Controllers\\Home", "table"]);

Config::$route->get('/ss/{:\w+}', ["App\\Controllers\\Home", "ss"]);
