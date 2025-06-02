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
    // Route::get('/turismo/{ciudad}', [ApiLugaresTuristicos::class, 'getLugaresTuristicos']);

    Route::get('/api/ciudades', function () {
        return Ciudad::all();
    });

    Route::get('/preferencias', function () {
        return view('auth.preferencias');
    })->name('preferencias');

    Route::post('/preferencias', [AuthenticatedSessionController::class, 'storePreference'])->name('guardar.preferencia');

    Route::post('/crear-itinerario', [ItinerarioController::class, 'store'])->name('itinerarios.create');

    Route::post('/guardar-itinerario', [ItinerarioController::class, 'guardar'])->name('itinerario.guardar-lugares');

    Route::get('/admin/panel', function () {
        if (Auth::user()->id !== 1) {
            abort(403, 'Acceso no autorizado');
        }
        return view('admin.panel');
    })->name('admin.panel');

    Route::post('/admin/llamar-api', [ApiLugaresTuristicos::class, 'getLugaresTuristicos'])
        ->middleware('auth') // o 'admin' si usas middleware personalizado
        ->name('admin.llamar-api');
});

Route::get('/itinerarios', [ItinerarioController::class, 'listar'])->name('itinerarios.listar');


Route::get('/itinerarios/{id}', [ItinerarioController::class, 'mostrar'])->name('itinerarios.mostrar');
