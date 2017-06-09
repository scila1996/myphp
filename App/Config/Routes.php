<?php

use System\Libraries\Routing\Route;

Route::match("/", "Home::index");
Route::match("/get/{id}", "Home::index")->where("id", ".+");
