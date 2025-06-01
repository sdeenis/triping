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
        $lugares = Lugar::where('ciudad_id', $validated['ciudad_id'])->get();
        $autor = User::where('id', $itinerario->user_id)->first();
        // Redirigir a la vista de edición o continuación del itinerario
        return view('itinerarios.configurate', [
            'itinerario' => $itinerario,
            'lugares' => $lugares,
            'autor' => $autor->name
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

public function listar()
{
    $itinerarios = Itinerario::with('ciudad', 'usuario')
        ->has('lugares')  // Solo itinerarios que tengan lugares
        ->get();

    return view('itinerarios.index', ['itinerarios' => $itinerarios]);
}

    public function mostrar($id)
    {
        $itinerario = Itinerario::with('ciudad', 'usuario', 'lugares')->findOrFail($id);
        return view('itinerarios.mostrar', ['itinerario' => $itinerario]);
    }
}
