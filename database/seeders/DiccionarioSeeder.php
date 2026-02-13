<?php

namespace Database\Seeders;

use App\Models\Diccionario;
use Illuminate\Database\Seeder;

class DiccionarioSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            ['numero' => 1, 'tipo' => 'guardia_tipo_documento', 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'tipo' => 'guardia_tipo_documento', 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'tipo' => 'guardia_tipo_documento', 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'tipo' => 'guardia_tipo_documento', 'descripcion' => 'Otro', 'siglas' => 'OTR'],

            ['numero' => 1, 'tipo' => 'guardia_turno', 'descripcion' => 'Manana', 'siglas' => 'MAN'],
            ['numero' => 2, 'tipo' => 'guardia_turno', 'descripcion' => 'Tarde', 'siglas' => 'TAR'],
            ['numero' => 3, 'tipo' => 'guardia_turno', 'descripcion' => 'Noche', 'siglas' => 'NOC'],

            ['numero' => 1, 'tipo' => 'producto_estado', 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'tipo' => 'producto_estado', 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
            ['numero' => 3, 'tipo' => 'producto_estado', 'descripcion' => 'Descontinuado', 'siglas' => 'DSC'],

            ['numero' => 1, 'tipo' => 'producto_unidad', 'descripcion' => 'Unidad', 'siglas' => 'UNI'],
            ['numero' => 2, 'tipo' => 'producto_unidad', 'descripcion' => 'Litro', 'siglas' => 'LTR'],
            ['numero' => 3, 'tipo' => 'producto_unidad', 'descripcion' => 'Kilogramo', 'siglas' => 'KGM'],
            ['numero' => 4, 'tipo' => 'producto_unidad', 'descripcion' => 'Caja', 'siglas' => 'CAJ'],
            ['numero' => 5, 'tipo' => 'producto_unidad', 'descripcion' => 'Set', 'siglas' => 'SET'],
            ['numero' => 6, 'tipo' => 'producto_unidad', 'descripcion' => 'Paquete', 'siglas' => 'PAQ'],

            ['numero' => 1, 'tipo' => 'proveedor_estado', 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'tipo' => 'proveedor_estado', 'descripcion' => 'Inactivo', 'siglas' => 'INA'],

            ['numero' => 1, 'tipo' => 'cliente_tipo_documento', 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'tipo' => 'cliente_tipo_documento', 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'tipo' => 'cliente_tipo_documento', 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'tipo' => 'cliente_tipo_documento', 'descripcion' => 'Otro', 'siglas' => 'OTR'],
        ];

        $tiposBase = collect($registros)->pluck('tipo')->unique()->all();
        Diccionario::whereIn('tipo', $tiposBase)->delete();

        foreach ($registros as $registro) {
            Diccionario::create($registro);
        }
    }
}
