<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\Category;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $z1 = Zone::updateOrCreate(
            ['code' => 'Z-001'],
            ['name' => 'Frutas', 'description' => 'Zona de frutas frescas']
        );
        $z2 = Zone::updateOrCreate(
            ['code' => 'Z-002'],
            ['name' => 'Lácteos', 'description' => 'Zona de lácteos y refrigerados']
        );

        $c1 = Category::updateOrCreate(
            ['code' => 'CAT-001'],
            ['zone_id' => $z1->id, 'name' => 'Citricos']
        );
        $c2 = Category::updateOrCreate(
            ['code' => 'CAT-002'],
            ['zone_id' => $z1->id, 'name' => 'Tropicales']
        );
        $c3 = Category::updateOrCreate(
            ['code' => 'CAT-010'],
            ['zone_id' => $z2->id, 'name' => 'Leches']
        );

        Product::updateOrCreate(
            ['sku' => 'NAR-001'],
            [
                'category_id' => $c1->id,
                'barcode' => '1234567890123',
                'name' => 'Naranja',
                'description' => 'Naranja fresca por kilo',
                'price' => 0.95,
                'stock_quantity' => 120.500,
                'unit' => 'kg',
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'MLE-001'],
            [
                'category_id' => $c3->id,
                'barcode' => '9876543210987',
                'name' => 'Leche entera 1L',
                'description' => 'Leche pasteurizada envasada',
                'price' => 1.25,
                'stock_quantity' => 50,
                'unit' => 'unidad',
            ]
        );
    }
}
