<?php

use System\Core\Config;

Config::$route->any('/', ["App\\Controllers\\Home", "index"]);
Config::$route->any('/view/{:customer}', ["App\\Controllers\\Home", "viewArticle"]);
Config::$route->any('/view/{:cms}', ["App\\Controllers\\Home", "viewArticle"]);
