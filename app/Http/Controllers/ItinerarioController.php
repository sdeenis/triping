<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerario;

class ItinerarioController extends Controller
{
    public function store(Request $request)
    {
        // Validación básica
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ciudad_id' => 'required|exists:ciudades,id',
            'dias' => 'required|integer|min:1',
        ]);



        // Crear el itinerario
        $itinerario = new Itinerario();
        $itinerario->titulo = $validated['titulo'];
        $itinerario->ciudad_id = $validated['ciudad_id'];
        $itinerario->dias = $validated['dias'];
        $itinerario->user_id = auth()->id(); // si el usuario está autenticado
        $itinerario->save();

        return response()->json([
            'message' => 'Itinerario creado con éxito',
            'itinerario' => $itinerario,
        ], 201);
    }
}
