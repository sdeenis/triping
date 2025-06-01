<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerario;
use App\Models\Ciudad;
use App\Models\Lugar;
use App\Models\User;
use App\Models\ItinerarioLugar;

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

        // Obtener los lugares de la ciudad

        $autor = User::where('id', $itinerario->user_id)->first();
        $preferencia = $autor->preferencias;
         $lugares = Lugar::where('ciudad_id', $validated['ciudad_id'])
        ->orderByRaw("categoria = ? DESC", [$preferencia])
        ->get();

        return view('itinerarios.configurate', [
            'itinerario' => $itinerario,
            'lugares' => $lugares,
            'autor' => $autor->name,
            'preferenciaAutor' => $preferencia,
        ]);
    }

    public function guardar(Request $request)
    {
        $idItinerario = $request->input('itinerario_id');
        $datos = $request->except('_token', 'itinerario_id');

        // dd($datos, $idItinerario);
        foreach ($datos as $key => $value) {

            [$dia, $lugarId] = explode('-', $key);
            ItinerarioLugar::create([
                'itinerario_id' => $idItinerario,
                'lugar_id' => $lugarId,
                'dia' => $dia,
            ]);
        }
        // Redirigir a la vista de itinerarios o donde desees
        return redirect()->route('home')->with('success', 'Itinerario guardado con éxito.');
    }

public function listar(Request $request)
{
    // Obtener ciudades con id => nombre
    $ciudades = Ciudad::pluck('nombre', 'id');

    $query = Itinerario::with('ciudad', 'usuario')->has('lugares');

    // Filtros
    if ($request->filled('ciudad')) {
        $query->where('ciudad_id', $request->ciudad);
    }

    if ($request->filled('dias')) {
        $query->where('dias', $request->dias);
    }

    if ($request->filled('fecha')) {
        $fecha = match ($request->fecha) {
            'hoy' => now()->startOfDay(),
            '7dias' => now()->subDays(7),
            'mes' => now()->subMonth(),
            default => null,
        };

        if ($fecha) {
            $query->where('created_at', '>=', $fecha);
        }
    }

    if ($request->filled('creador')) {
        $query->whereHas('usuario', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->creador . '%');
        });
    }

    $itinerarios = $query->latest()->get();

    return view('itinerarios.index', compact('itinerarios', 'ciudades'));
}

    public function mostrar($id)
    {
        $itinerario = Itinerario::with('ciudad', 'usuario', 'lugares')->findOrFail($id);
        return view('itinerarios.mostrar', ['itinerario' => $itinerario]);
    }
}
