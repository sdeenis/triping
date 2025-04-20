<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/hola', [LandingController::class, 'index']);
