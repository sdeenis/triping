<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerario extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si se llama "itinerarios", que es el plural estándar de Laravel)
    protected $table = 'itinerarios';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'ciudad_id',
        'user_id',
        'dias',
        'descripcion',
        'terminado',
        'publico',
    ];

    // Relaciones

    /**
     * Itinerario pertenece a una ciudad
     */
    public function ciudad()
    {
        // return $this->belongsTo(Ciudad::class); es lo mismo que el siguiente:
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    /**
     * Itinerario pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
