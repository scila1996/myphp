<?php

use System\Libraries\Router\Route;

Route::get("/", "Home::index");
Route::get("/get/{id:\d+}", "Home::index");
Route::post("/get/{id:\d+}", "Home::test");

Route::get("/database", "Home::database");
