<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'code' => 'cash',
                'name' => 'Efectivo',
                'description' => 'Pago en efectivo',
                'is_active' => true,
                'requires_reference' => false,
            ],
            [
                'code' => 'card',
                'name' => 'Tarjeta',
                'description' => 'Pago con tarjeta de débito o crédito',
                'is_active' => true,
                'requires_reference' => true,
            ],
            [
                'code' => 'transfer',
                'name' => 'Transferencia',
                'description' => 'Transferencia bancaria',
                'is_active' => true,
                'requires_reference' => true,
            ],
            [
                'code' => 'yape',
                'name' => 'Yape',
                'description' => 'Pago con Yape',
                'is_active' => true,
                'requires_reference' => true,
            ],
            [
                'code' => 'plin',
                'name' => 'Plin',
                'description' => 'Pago con Plin',
                'is_active' => true,
                'requires_reference' => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
