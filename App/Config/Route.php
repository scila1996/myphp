<?php

use System\Libraries\Router\Route;

Route::GET("/", "Home");
Route::GET("/get/{id:\d+}", "Home::index");
Route::GET("/database", "Home::database");
