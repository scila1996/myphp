<?php

use System\Config\Route;

Route::get("/get/{id:\d+}", "Home::index");
