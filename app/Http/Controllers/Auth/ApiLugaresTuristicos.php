<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ciudad;
use App\Models\Lugar;


class ApiLugaresTuristicos extends Controller
{
    public function getLugaresTuristicos(Request $request)
    {
        $ciudad = $request->input('ciudad');
        $apiKey = env('FOURSQUARE_API_KEY');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $apiKey,
            'Accept-Language' => 'es',
        ])->get('https://api.foursquare.com/v3/places/search', [
            'near' => $ciudad,
            'limit' => 50,
            'sort' => 'RELEVANCE',
            // 'categories' => '16025,16017,16032,10027,13065' // opcional: Landmarks and Outdoors
        ]);

        $lugares = $response->json();
        // return $lugares;
        $this->saveDataDB($lugares, $ciudad);
    }

    public function saveDataDB($lugares, $ciudad)
    {

        $ciudadModel = Ciudad::where('nombre', $ciudad)->first();

        if (!$ciudadModel) {
            return response()->json(['error' => 'Ciudad no encontrada'], 404);
        }

        $ciudadId = $ciudadModel->id;

        $cont = 0;
        foreach ($lugares['results'] as $lugar) {

            $id_api = $lugar['fsq_id'];
            $nombre = $lugar['name'];

            $categoria = 'Otros(' . $lugar['categories'][0]['id'] . ')';
            foreach ($lugar['categories'] as $cat) {
                if ($cat['id'] == '16017' || $cat['id'] == '16032') {
                    $categoria = 'Parque';
                    break;
                } else if (preg_match('/^16/', $cat['id'])) {
                    $categoria = 'Monumento';
                    break;
                } else if ($cat['id'] == '10027') {
                    $categoria = 'Museo';
                    break;
                } else if ($cat['id'] == '13065') {
                    $categoria = 'Restaurante';
                    break;
                }
            }
            $lat = $lugar['geocodes']['main']['latitude'];
            $long = $lugar['geocodes']['main']['longitude'];

            $direccion = $lugar['location']['formatted_address'] ?? null;
            $descripcion = $lugar['description'] ?? null;

            $lugarExistente = Lugar::where('foursquare_id', $id_api)->first();

            if (!$lugarExistente) {
                // Crear nuevo registro
                $nuevoLugar = new Lugar();
                $nuevoLugar->foursquare_id = $id_api;
                $nuevoLugar->ciudad_id = $ciudadId;
                $nuevoLugar->nombre = $nombre;
                $nuevoLugar->descripcion = $descripcion;
                $nuevoLugar->categoria = $categoria;
                $nuevoLugar->direccion = $direccion;
                $nuevoLugar->latitud = $lat;
                $nuevoLugar->longitud = $long;
                // dd($nuevoLugar);
                $nuevoLugar->save();
            }
            $cont++;
        }

        return response()->json([
            'message' => 'Lugares turísticos guardados con éxito',
            'total_lugares' => $cont,
        ], 201);
    }
}
    // llamada de prueba desde su web
    //  --url 'https://api.foursquare.com/v3/places/search?near=madrid&sort=POPULARITY&limit=1' \
