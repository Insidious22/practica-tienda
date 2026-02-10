<?php

namespace Database\Seeders;

use App\Models\InventarioItem;
use Illuminate\Database\Seeder;

class GuardiasInventarioSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nombre' => 'Radio', 'codigo_serie' => 'INV-RAD-001', 'cantidad' => 10],
            ['nombre' => 'Chaleco', 'codigo_serie' => 'INV-CHA-001', 'cantidad' => 8],
            ['nombre' => 'Linterna', 'codigo_serie' => 'INV-LIN-001', 'cantidad' => 12],
            ['nombre' => 'Bastón', 'codigo_serie' => 'INV-BAS-001', 'cantidad' => 6],
            ['nombre' => 'Silbato', 'codigo_serie' => 'INV-SIL-001', 'cantidad' => 20],
            ['nombre' => 'Guantes', 'codigo_serie' => 'INV-GUA-001', 'cantidad' => 15],
        ];

        foreach ($items as $item) {
            InventarioItem::updateOrCreate(
                ['codigo_serie' => $item['codigo_serie']],
                ['nombre' => $item['nombre'], 'cantidad' => $item['cantidad']]
            );
        }
    }
}

