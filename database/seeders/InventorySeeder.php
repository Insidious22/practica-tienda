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
        $z1 = Zone::create(['code' => 'Z-001', 'name' => 'Frutas', 'description' => 'Zona de frutas frescas']);
        $z2 = Zone::create(['code' => 'Z-002', 'name' => 'Lácteos', 'description' => 'Zona de lácteos y refrigerados']);

        $c1 = Category::create(['zone_id' => $z1->id, 'name' => 'Cítricos', 'code' => 'CAT-001']);
        $c2 = Category::create(['zone_id' => $z1->id, 'name' => 'Tropicales', 'code' => 'CAT-002']);
        $c3 = Category::create(['zone_id' => $z2->id, 'name' => 'Leches', 'code' => 'CAT-010']);

        Product::create([
            'category_id' => $c1->id,
            'barcode' => '1234567890123',
            'sku' => 'NAR-001',
            'name' => 'Naranja',
            'description' => 'Naranja fresca por kilo',
            'price' => 0.95,
            'stock_quantity' => 120.500,
            'unit' => 'kg',
        ]);

        Product::create([
            'category_id' => $c3->id,
            'barcode' => '9876543210987',
            'sku' => 'MLE-001',
            'name' => 'Leche entera 1L',
            'description' => 'Leche pasteurizada envasada',
            'price' => 1.25,
            'stock_quantity' => 50,
            'unit' => 'unidad',
        ]);
    }
}
