<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    protected $table = 'lugares';

    protected $fillable = [
        'foursquare_id',
        'ciudad_id',
        'nombre',
        'descripcion',
        'categoria',
        'direccion',
        'latitud',
        'longitud',
    ];

    /**
     * Lugar pertenece a una ciudad.
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function itinerarios()
    {
        return $this->belongsToMany(Itinerario::class, 'itinerario_lugar')
            ->withPivot('dia')
            ->withTimestamps();
    }
}
