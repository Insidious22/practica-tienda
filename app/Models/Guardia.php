<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardia extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'tipo_documento',
        'turno',
        'codigo_unico',
        'activo',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}