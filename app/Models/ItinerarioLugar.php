<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItinerarioLugar extends Pivot
{
    protected $table = 'itinerario_lugar';

    protected $fillable = [
        'itinerario_id',
        'lugar_id',
        'dia',
    ];

    public $timestamps = true;
}
