<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function tipoDocumento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Diccionario::siglaDeNumero('guardia_tipo_documento', $value) ?? 'CED',
            set: function ($value) {
                if ($value === null || $value === '') {
                    return 1;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                return Diccionario::numeroDeSigla('guardia_tipo_documento', (string) $value) ?? 1;
            }
        );
    }

    protected function turno(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Diccionario::siglaDeNumero('guardia_turno', $value) ?? 'MAN',
            set: function ($value) {
                if ($value === null || $value === '') {
                    return 1;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                return Diccionario::numeroDeSigla('guardia_turno', (string) $value) ?? 1;
            }
        );
    }
}
