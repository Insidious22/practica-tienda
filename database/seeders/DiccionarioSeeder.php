<?php

namespace Database\Seeders;

use App\Models\Diccionario;
use Illuminate\Database\Seeder;

class DiccionarioSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            ['numero' => 1, 'tipo' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'tipo' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'tipo' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Otro', 'siglas' => 'OTR'],

            ['numero' => 1, 'tipo' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Manana', 'siglas' => 'MAN'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Tarde', 'siglas' => 'TAR'],
            ['numero' => 3, 'tipo' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Noche', 'siglas' => 'NOC'],

            ['numero' => 1, 'tipo' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
            ['numero' => 3, 'tipo' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Descontinuado', 'siglas' => 'DSC'],

            ['numero' => 1, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Unidad', 'siglas' => 'UNI'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Litro', 'siglas' => 'LTR'],
            ['numero' => 3, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Kilogramo', 'siglas' => 'KGM'],
            ['numero' => 4, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Caja', 'siglas' => 'CAJ'],
            ['numero' => 5, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Set', 'siglas' => 'SET'],
            ['numero' => 6, 'tipo' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Paquete', 'siglas' => 'PAQ'],

            ['numero' => 1, 'tipo' => Diccionario::TIPO_PROVEEDOR_ESTADO, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_PROVEEDOR_ESTADO, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],

            ['numero' => 1, 'tipo' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'tipo' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'tipo' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'tipo' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Otro', 'siglas' => 'OTR'],
        ];

        $tiposBase = collect($registros)->pluck('tipo')->unique()->all();
        Diccionario::whereIn('tipo', $tiposBase)->delete();

        foreach ($registros as $registro) {
            Diccionario::create($registro);
        }
    }
}
