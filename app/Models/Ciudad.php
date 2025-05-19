<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';
    protected $fillable = [
        'nombre',
        'latitud',
        'longitud',
        'descripcion',
        'created_by',
    ];

    // Relación con el usuario que la creó
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
