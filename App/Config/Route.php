<?php

use System\Libraries\Router\Route;

Route::GET("/", "Home");
Route::GET("/get/{id}", "Home::index");
Route::GET("/database", "Home::database");
