<?php
require __DIR__ . '/auth.php';

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
