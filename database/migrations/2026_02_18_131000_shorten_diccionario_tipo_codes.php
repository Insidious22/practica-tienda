<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE diccionario
            SET tipo = CASE tipo
                WHEN 'guardia_tipo_documento' THEN 'GTD'
                WHEN 'guardia_turno' THEN 'GTR'
                WHEN 'producto_estado' THEN 'PES'
                WHEN 'producto_unidad' THEN 'PUN'
                WHEN 'proveedor_estado' THEN 'PVE'
                WHEN 'cliente_tipo_documento' THEN 'CTD'
                ELSE tipo
            END
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE diccionario
            SET tipo = CASE tipo
                WHEN 'GTD' THEN 'guardia_tipo_documento'
                WHEN 'GTR' THEN 'guardia_turno'
                WHEN 'PES' THEN 'producto_estado'
                WHEN 'PUN' THEN 'producto_unidad'
                WHEN 'PVE' THEN 'proveedor_estado'
                WHEN 'CTD' THEN 'cliente_tipo_documento'
                ELSE tipo
            END
        ");
    }
};
