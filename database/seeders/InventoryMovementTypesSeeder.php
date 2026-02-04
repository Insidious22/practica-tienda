<?php

namespace Database\Seeders;

use App\Models\InventoryMovementType;
use Illuminate\Database\Seeder;

class InventoryMovementTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'purchase',
                'name' => 'Compra',
                'direction' => 'in',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Entrada de mercancía por compra a proveedor',
            ],
            [
                'code' => 'sale',
                'name' => 'Venta',
                'direction' => 'out',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Salida de mercancía por venta',
            ],
            [
                'code' => 'adjustment_in',
                'name' => 'Ajuste positivo',
                'direction' => 'in',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Ajuste de inventario que incrementa el stock',
            ],
            [
                'code' => 'adjustment_out',
                'name' => 'Ajuste negativo',
                'direction' => 'out',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Ajuste de inventario que reduce el stock',
            ],
            [
                'code' => 'transfer_in',
                'name' => 'Transferencia entrada',
                'direction' => 'in',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Entrada de mercancía por transferencia desde otra zona',
            ],
            [
                'code' => 'transfer_out',
                'name' => 'Transferencia salida',
                'direction' => 'out',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Salida de mercancía por transferencia a otra zona',
            ],
            [
                'code' => 'return_customer',
                'name' => 'Devolución cliente',
                'direction' => 'in',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Entrada de mercancía por devolución de cliente',
            ],
            [
                'code' => 'return_supplier',
                'name' => 'Devolución proveedor',
                'direction' => 'out',
                'affects_stock' => true,
                'requires_reference' => true,
                'is_system' => true,
                'description' => 'Salida de mercancía por devolución a proveedor',
            ],
            [
                'code' => 'shrinkage',
                'name' => 'Merma',
                'direction' => 'out',
                'affects_stock' => true,
                'requires_reference' => false,
                'is_system' => true,
                'description' => 'Pérdida de mercancía por daño, vencimiento u otros',
            ],
            [
                'code' => 'initial',
                'name' => 'Inventario inicial',
                'direction' => 'in',
                'affects_stock' => true,
                'requires_reference' => false,
                'is_system' => true,
                'description' => 'Carga inicial de inventario',
            ],
        ];

        foreach ($types as $type) {
            InventoryMovementType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
