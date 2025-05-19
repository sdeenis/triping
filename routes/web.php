<?php
require __DIR__ . '/auth.php';


use App\Http\Controllers\Auth\ApiLugaresTuristicos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Ciudad;
use App\Http\Controllers\ItinerarioController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/turismo/{ciudad}', [ApiLugaresTuristicos::class, 'getLugaresTuristicos']);

    Route::get('/api/ciudades', function () {
        return Ciudad::all();
    });

    Route::post('/crear-itinerario', [ItinerarioController::class, 'store'])->name('itinerarios.create');
});
