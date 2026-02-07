<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $z1 = Zone::where('code', 'Z-001')
            ->orWhere('name', 'Frutas')
            ->first();

        if (!$z1) {
            $z1 = new Zone();
        }

        $z1->fill([
            'code' => 'Z-001',
            'name' => 'Frutas',
            'description' => 'Zona de frutas frescas',
        ]);
        $z1->save();

        $z2 = Zone::where('code', 'Z-002')
            ->orWhereIn('name', ['Lacteos', 'Lacteos', 'Lácteos'])
            ->first();

        if (!$z2) {
            $z2 = new Zone();
        }

        $z2->fill([
            'code' => 'Z-002',
            'name' => 'Lacteos',
            'description' => 'Zona de lacteos y refrigerados',
        ]);
        $z2->save();

        $c1 = Category::updateOrCreate(
            ['zone_id' => $z1->id, 'name' => 'Citricos'],
            ['code' => 'CAT-001']
        );

        Category::updateOrCreate(
            ['zone_id' => $z1->id, 'name' => 'Tropicales'],
            ['code' => 'CAT-002']
        );

        $c3 = Category::updateOrCreate(
            ['zone_id' => $z2->id, 'name' => 'Leches'],
            ['code' => 'CAT-010']
        );

        Product::updateOrCreate([
            'barcode' => '1234567890123',
        ], [
            'category_id' => $c1->id,
            'sku' => 'NAR-001',
            'name' => 'Naranja',
            'description' => 'Naranja fresca por kilo',
            'price' => 0.95,
            'stock_quantity' => 120.500,
            'unit' => 'kg',
        ]);

        Product::updateOrCreate([
            'barcode' => '9876543210987',
        ], [
            'category_id' => $c3->id,
            'sku' => 'MLE-001',
            'name' => 'Leche entera 1L',
            'description' => 'Leche pasteurizada envasada',
            'price' => 1.25,
            'stock_quantity' => 50,
            'unit' => 'unidad',
        ]);
    }
}
