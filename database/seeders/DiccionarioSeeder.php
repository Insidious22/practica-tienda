<?php

namespace Database\Seeders;

use App\Models\Diccionario;
use Illuminate\Database\Seeder;

class DiccionarioSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            ['orden' => 1, 'tabla' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Cedula', 'valor' => 'CED'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'RUC', 'valor' => 'RUC'],
            ['orden' => 3, 'tabla' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Pasaporte', 'valor' => 'PAS'],
            ['orden' => 4, 'tabla' => Diccionario::TIPO_GUARDIA_TIPO_DOCUMENTO, 'descripcion' => 'Otro', 'valor' => 'OTR'],

            ['orden' => 1, 'tabla' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Manana', 'valor' => 'MAN'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Tarde', 'valor' => 'TAR'],
            ['orden' => 3, 'tabla' => Diccionario::TIPO_GUARDIA_TURNO, 'descripcion' => 'Noche', 'valor' => 'NOC'],

            ['orden' => 1, 'tabla' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Activo', 'valor' => 'ACT'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Inactivo', 'valor' => 'INA'],
            ['orden' => 3, 'tabla' => Diccionario::TIPO_PRODUCTO_ESTADO, 'descripcion' => 'Descontinuado', 'valor' => 'DSC'],

            ['orden' => 1, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Unidad', 'valor' => 'UNI'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Litro', 'valor' => 'LTR'],
            ['orden' => 3, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Kilogramo', 'valor' => 'KGM'],
            ['orden' => 4, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Caja', 'valor' => 'CAJ'],
            ['orden' => 5, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Set', 'valor' => 'SET'],
            ['orden' => 6, 'tabla' => Diccionario::TIPO_PRODUCTO_UNIDAD, 'descripcion' => 'Paquete', 'valor' => 'PAQ'],

            ['orden' => 1, 'tabla' => Diccionario::TIPO_PROVEEDOR_ESTADO, 'descripcion' => 'Activo', 'valor' => 'ACT'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_PROVEEDOR_ESTADO, 'descripcion' => 'Inactivo', 'valor' => 'INA'],

            ['orden' => 1, 'tabla' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Cedula', 'valor' => 'CED'],
            ['orden' => 2, 'tabla' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'RUC', 'valor' => 'RUC'],
            ['orden' => 3, 'tabla' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Pasaporte', 'valor' => 'PAS'],
            ['orden' => 4, 'tabla' => Diccionario::TIPO_CLIENTE_TIPO_DOCUMENTO, 'descripcion' => 'Otro', 'valor' => 'OTR'],
        ];

        foreach ($registros as $registro) {
            Diccionario::updateOrCreate(
                [
                    'tabla' => $registro['tabla'],
                    'orden' => $registro['orden'],
                ],
                [
                    'id_cliente' => null,
                    'valor' => $registro['valor'],
                    'descripcion' => $registro['descripcion'],
                    'estado' => 'A',
                ]
            );
        }
    }
}
