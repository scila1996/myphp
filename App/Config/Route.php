<?php

use System\Config\Route;

Route::get("/", "Home::index");
Route::get("/get/{id:\d+}", "Home::index");
Route::post("/get/{id:\d+}", "Home::test");
