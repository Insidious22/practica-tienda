<?php

namespace Database\Seeders;

use App\Models\Zone;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Zonas
        $zones = [
            [
                'code' => 'Z-001',
                'name' => 'Zona Norte',
                'description' => 'Sector norte del almacén - Productos electrónicos',
            ],
            [
                'code' => 'Z-002',
                'name' => 'Zona Sur',
                'description' => 'Sector sur del almacén - Productos básicos',
            ],
            [
                'code' => 'Z-003',
                'name' => 'Zona Este',
                'description' => 'Sector este del almacén - Alimentos y bebidas',
            ],
            [
                'code' => 'Z-004',
                'name' => 'Zona Oeste',
                'description' => 'Sector oeste del almacén - Ropa y accesorios',
            ],
        ];

        $createdZones = [];
        foreach ($zones as $zone) {
            $createdZones[] = Zone::create($zone);
        }

        // Crear Categorías
        $categories = [
            // Zona Norte - Electrónica
            [
                'zone_id' => $createdZones[0]->id,
                'name' => 'Laptops',
                'code' => 'CAT-001',
                'description' => 'Computadoras portátiles de última generación',
            ],
            [
                'zone_id' => $createdZones[0]->id,
                'name' => 'Smartphones',
                'code' => 'CAT-002',
                'description' => 'Teléfonos inteligentes de marcas reconocidas',
            ],
            [
                'zone_id' => $createdZones[0]->id,
                'name' => 'Tablets',
                'code' => 'CAT-003',
                'description' => 'Tablets de diversos tamaños y especificaciones',
            ],
            // Zona Sur - Básicos
            [
                'zone_id' => $createdZones[1]->id,
                'name' => 'Herramientas',
                'code' => 'CAT-004',
                'description' => 'Herramientas para construcción y reparación',
            ],
            [
                'zone_id' => $createdZones[1]->id,
                'name' => 'Iluminación',
                'code' => 'CAT-005',
                'description' => 'Bombillas y sistemas de iluminación',
            ],
            // Zona Este - Alimentos
            [
                'zone_id' => $createdZones[2]->id,
                'name' => 'Bebidas',
                'code' => 'CAT-006',
                'description' => 'Refrescos, jugos y bebidas diversas',
            ],
            [
                'zone_id' => $createdZones[2]->id,
                'name' => 'Snacks',
                'code' => 'CAT-007',
                'description' => 'Productos de botana y aperitivos',
            ],
            // Zona Oeste - Ropa
            [
                'zone_id' => $createdZones[3]->id,
                'name' => 'Camisetas',
                'code' => 'CAT-008',
                'description' => 'Camisetas y blusas para hombre y mujer',
            ],
            [
                'zone_id' => $createdZones[3]->id,
                'name' => 'Pantalones',
                'code' => 'CAT-009',
                'description' => 'Pantalones jeans, casuales y formales',
            ],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $createdCategories[] = Category::create($category);
        }

        // Crear Productos
        $products = [
            // Laptops
            [
                'category_id' => $createdCategories[0]->id,
                'barcode' => '8471234567890',
                'sku' => 'SKU-DELL-001',
                'name' => 'Dell XPS 13',
                'description' => 'Laptop ultradelgada de 13 pulgadas con procesador Intel de última generación',
                'price' => 1299.99,
                'stock_quantity' => 15,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            [
                'category_id' => $createdCategories[0]->id,
                'barcode' => '8471234567891',
                'sku' => 'SKU-HP-001',
                'name' => 'HP Pavilion 15',
                'description' => 'Laptop versátil con pantalla de 15 pulgadas y buena batería',
                'price' => 749.99,
                'stock_quantity' => 8,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            [
                'category_id' => $createdCategories[0]->id,
                'barcode' => '8471234567892',
                'sku' => 'SKU-LENOVO-001',
                'name' => 'Lenovo ThinkPad',
                'description' => 'Laptop empresarial confiable y robusta',
                'price' => 899.99,
                'stock_quantity' => 3,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Smartphones
            [
                'category_id' => $createdCategories[1]->id,
                'barcode' => '8471234567893',
                'sku' => 'SKU-IPHONE-13',
                'name' => 'iPhone 13 Pro',
                'description' => 'Smartphone de Apple con cámara de 12MP y pantalla OLED',
                'price' => 999.00,
                'stock_quantity' => 12,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            [
                'category_id' => $createdCategories[1]->id,
                'barcode' => '8471234567894',
                'sku' => 'SKU-SAMSUNG-S21',
                'name' => 'Samsung Galaxy S21',
                'description' => 'Smartphone Android con pantalla Dynamic AMOLED',
                'price' => 799.99,
                'stock_quantity' => 18,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Tablets
            [
                'category_id' => $createdCategories[2]->id,
                'barcode' => '8471234567895',
                'sku' => 'SKU-IPAD-PRO',
                'name' => 'iPad Pro 12.9"',
                'description' => 'Tablet profesional de Apple con chip M1',
                'price' => 1099.00,
                'stock_quantity' => 2,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Herramientas
            [
                'category_id' => $createdCategories[3]->id,
                'barcode' => '8471234567896',
                'sku' => 'SKU-HAMMER-001',
                'name' => 'Martillo Stanley 16oz',
                'description' => 'Martillo profesional con mango ergonómico',
                'price' => 25.99,
                'stock_quantity' => 50,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            [
                'category_id' => $createdCategories[3]->id,
                'barcode' => '8471234567897',
                'sku' => 'SKU-DRILL-001',
                'name' => 'Taladro DeWalt 18V',
                'description' => 'Taladro inalámbrico profesional con batería incluida',
                'price' => 149.99,
                'stock_quantity' => 7,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Iluminación
            [
                'category_id' => $createdCategories[4]->id,
                'barcode' => '8471234567898',
                'sku' => 'SKU-LED-BULB',
                'name' => 'Bombilla LED 10W',
                'description' => 'Bombilla LED de bajo consumo con 25000 horas de vida',
                'price' => 12.99,
                'stock_quantity' => 200,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Bebidas
            [
                'category_id' => $createdCategories[5]->id,
                'barcode' => '8471234567899',
                'sku' => 'SKU-COLA-2L',
                'name' => 'Refresco Cola 2L',
                'description' => 'Botella de 2 litros de refresco cola',
                'price' => 2.99,
                'stock_quantity' => 300,
                'unit' => 'botella',
                'status' => 'active',
            ],
            [
                'category_id' => $createdCategories[5]->id,
                'barcode' => '8471234567900',
                'sku' => 'SKU-JUICE-1L',
                'name' => 'Jugo Natural 1L',
                'description' => 'Jugo de naranja 100% natural sin conservantes',
                'price' => 3.49,
                'stock_quantity' => 1,
                'unit' => 'botella',
                'status' => 'active',
            ],
            // Snacks
            [
                'category_id' => $createdCategories[6]->id,
                'barcode' => '8471234567901',
                'sku' => 'SKU-CHIPS-100G',
                'name' => 'Papas Fritas 100g',
                'description' => 'Papas fritas crujientes en presentación individual',
                'price' => 1.49,
                'stock_quantity' => 500,
                'unit' => 'bolsa',
                'status' => 'active',
            ],
            // Camisetas
            [
                'category_id' => $createdCategories[7]->id,
                'barcode' => '8471234567902',
                'sku' => 'SKU-TSHIRT-BLK-M',
                'name' => 'Camiseta Negra Básica M',
                'description' => 'Camiseta de algodón 100% en color negro talle medio',
                'price' => 19.99,
                'stock_quantity' => 45,
                'unit' => 'unidad',
                'status' => 'active',
            ],
            // Pantalones
            [
                'category_id' => $createdCategories[8]->id,
                'barcode' => '8471234567903',
                'sku' => 'SKU-JEANS-BLU-32',
                'name' => 'Jeans Azul Oscuro 32',
                'description' => 'Pantalón jeans clásico en azul oscuro talle 32',
                'price' => 59.99,
                'stock_quantity' => 22,
                'unit' => 'unidad',
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        echo "✅ Datos de demostración creados exitosamente!\n";
        echo "📊 Zonas creadas: " . count($createdZones) . "\n";
        echo "🏷️  Categorías creadas: " . count($createdCategories) . "\n";
        echo "📦 Productos creados: " . count($products) . "\n";
    }
}
