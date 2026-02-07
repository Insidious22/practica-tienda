<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'code' => 'Z-101',
                'name' => 'Zona Tecnologia',
                'description' => 'Sector de tecnologia y dispositivos',
            ],
            [
                'code' => 'Z-102',
                'name' => 'Zona Hogar',
                'description' => 'Sector de hogar y herramientas',
            ],
            [
                'code' => 'Z-103',
                'name' => 'Zona Consumo',
                'description' => 'Sector de alimentos y bebidas',
            ],
            [
                'code' => 'Z-104',
                'name' => 'Zona Moda',
                'description' => 'Sector de ropa y accesorios',
            ],
        ];

        $zonesByCode = [];
        foreach ($zones as $zoneData) {
            $zone = Zone::updateOrCreate(
                ['code' => $zoneData['code']],
                [
                    'name' => $zoneData['name'],
                    'description' => $zoneData['description'],
                ]
            );
            $zonesByCode[$zoneData['code']] = $zone;
        }

        $categories = [
            ['zone_code' => 'Z-101', 'name' => 'Laptops', 'code' => 'CAT-101', 'description' => 'Portatiles para trabajo y estudio'],
            ['zone_code' => 'Z-101', 'name' => 'Smartphones', 'code' => 'CAT-102', 'description' => 'Telefonos inteligentes de gama media y alta'],
            ['zone_code' => 'Z-101', 'name' => 'Audio', 'code' => 'CAT-103', 'description' => 'Auriculares y parlantes'],
            ['zone_code' => 'Z-102', 'name' => 'Herramientas', 'code' => 'CAT-104', 'description' => 'Herramientas para construccion y mantenimiento'],
            ['zone_code' => 'Z-102', 'name' => 'Iluminacion', 'code' => 'CAT-105', 'description' => 'Bombillas y luminarias'],
            ['zone_code' => 'Z-103', 'name' => 'Bebidas', 'code' => 'CAT-106', 'description' => 'Bebidas frias y calientes'],
            ['zone_code' => 'Z-103', 'name' => 'Snacks', 'code' => 'CAT-107', 'description' => 'Botanas y productos de impulso'],
            ['zone_code' => 'Z-104', 'name' => 'Camisetas', 'code' => 'CAT-108', 'description' => 'Camisetas y polos'],
            ['zone_code' => 'Z-104', 'name' => 'Pantalones', 'code' => 'CAT-109', 'description' => 'Jeans y pantalones casuales'],
        ];

        $categoriesByCode = [];
        foreach ($categories as $categoryData) {
            $zone = $zonesByCode[$categoryData['zone_code']];
            $category = Category::updateOrCreate(
                ['zone_id' => $zone->id, 'name' => $categoryData['name']],
                [
                    'code' => $categoryData['code'],
                    'description' => $categoryData['description'],
                ]
            );
            $categoriesByCode[$categoryData['code']] = $category;
        }

        $products = [
            ['category_code' => 'CAT-101', 'barcode' => '8471234568001', 'sku' => 'SKU-DELL-001', 'name' => 'Dell XPS 13', 'description' => 'Laptop ultradelgada de 13 pulgadas', 'price' => 1299.99, 'stock_quantity' => 14, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-101', 'barcode' => '8471234568002', 'sku' => 'SKU-HP-001', 'name' => 'HP Pavilion 15', 'description' => 'Laptop de uso mixto con 16GB RAM', 'price' => 749.99, 'stock_quantity' => 9, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-101', 'barcode' => '8471234568003', 'sku' => 'SKU-LENOVO-001', 'name' => 'Lenovo ThinkPad E14', 'description' => 'Laptop empresarial de 14 pulgadas', 'price' => 899.99, 'stock_quantity' => 4, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-101', 'barcode' => '8471234568004', 'sku' => 'SKU-ASUS-001', 'name' => 'ASUS VivoBook 14', 'description' => 'Laptop compacta para productividad', 'price' => 679.99, 'stock_quantity' => 11, 'unit' => 'unidad', 'status' => 'active'],

            ['category_code' => 'CAT-102', 'barcode' => '8471234568005', 'sku' => 'SKU-IPHONE-13', 'name' => 'iPhone 13 Pro', 'description' => 'Smartphone Apple con 256GB', 'price' => 999.00, 'stock_quantity' => 7, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-102', 'barcode' => '8471234568006', 'sku' => 'SKU-SAMSUNG-S21', 'name' => 'Samsung Galaxy S21', 'description' => 'Pantalla AMOLED de 6.2 pulgadas', 'price' => 799.99, 'stock_quantity' => 13, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-102', 'barcode' => '8471234568007', 'sku' => 'SKU-XIAOMI-12', 'name' => 'Xiaomi 12', 'description' => 'Smartphone gama alta de 128GB', 'price' => 649.99, 'stock_quantity' => 17, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-102', 'barcode' => '8471234568008', 'sku' => 'SKU-MOTO-G84', 'name' => 'Motorola G84', 'description' => 'Smartphone gama media de gran bateria', 'price' => 349.99, 'stock_quantity' => 6, 'unit' => 'unidad', 'status' => 'active'],

            ['category_code' => 'CAT-103', 'barcode' => '8471234568009', 'sku' => 'SKU-AUDIO-SONY', 'name' => 'Sony WH-1000XM4', 'description' => 'Auriculares con cancelacion de ruido', 'price' => 329.99, 'stock_quantity' => 8, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-103', 'barcode' => '8471234568010', 'sku' => 'SKU-AUDIO-JBL', 'name' => 'JBL Flip 6', 'description' => 'Parlante bluetooth resistente al agua', 'price' => 139.99, 'stock_quantity' => 16, 'unit' => 'unidad', 'status' => 'active'],

            ['category_code' => 'CAT-104', 'barcode' => '8471234568011', 'sku' => 'SKU-HAMMER-001', 'name' => 'Martillo Stanley 16oz', 'description' => 'Martillo profesional con mango ergonomico', 'price' => 25.99, 'stock_quantity' => 42, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-104', 'barcode' => '8471234568012', 'sku' => 'SKU-DRILL-001', 'name' => 'Taladro DeWalt 18V', 'description' => 'Taladro inalambrico con bateria', 'price' => 149.99, 'stock_quantity' => 10, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-104', 'barcode' => '8471234568013', 'sku' => 'SKU-SCREW-SET', 'name' => 'Set Destornilladores 8p', 'description' => 'Set de destornilladores magneticos', 'price' => 19.90, 'stock_quantity' => 36, 'unit' => 'set', 'status' => 'active'],

            ['category_code' => 'CAT-105', 'barcode' => '8471234568014', 'sku' => 'SKU-LED-BULB', 'name' => 'Bombilla LED 10W', 'description' => 'Bombilla LED de bajo consumo', 'price' => 12.99, 'stock_quantity' => 180, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-105', 'barcode' => '8471234568015', 'sku' => 'SKU-LAMP-DESK', 'name' => 'Lampara de Escritorio', 'description' => 'Lampara LED regulable', 'price' => 39.90, 'stock_quantity' => 21, 'unit' => 'unidad', 'status' => 'active'],

            ['category_code' => 'CAT-106', 'barcode' => '8471234568016', 'sku' => 'SKU-COLA-2L', 'name' => 'Refresco Cola 2L', 'description' => 'Botella de 2 litros', 'price' => 2.99, 'stock_quantity' => 240, 'unit' => 'botella', 'status' => 'active'],
            ['category_code' => 'CAT-106', 'barcode' => '8471234568017', 'sku' => 'SKU-JUICE-1L', 'name' => 'Jugo Natural 1L', 'description' => 'Jugo de naranja sin conservantes', 'price' => 3.49, 'stock_quantity' => 12, 'unit' => 'botella', 'status' => 'active'],
            ['category_code' => 'CAT-106', 'barcode' => '8471234568018', 'sku' => 'SKU-WATER-600', 'name' => 'Agua Mineral 600ml', 'description' => 'Botella individual de agua', 'price' => 1.15, 'stock_quantity' => 320, 'unit' => 'botella', 'status' => 'active'],

            ['category_code' => 'CAT-107', 'barcode' => '8471234568019', 'sku' => 'SKU-CHIPS-100G', 'name' => 'Papas Fritas 100g', 'description' => 'Bolsa individual de papas fritas', 'price' => 1.49, 'stock_quantity' => 260, 'unit' => 'bolsa', 'status' => 'active'],
            ['category_code' => 'CAT-107', 'barcode' => '8471234568020', 'sku' => 'SKU-COOKIES-90G', 'name' => 'Galletas 90g', 'description' => 'Galletas dulces surtidas', 'price' => 1.79, 'stock_quantity' => 190, 'unit' => 'paquete', 'status' => 'active'],

            ['category_code' => 'CAT-108', 'barcode' => '8471234568021', 'sku' => 'SKU-TSHIRT-BLK-M', 'name' => 'Camiseta Negra Basica M', 'description' => 'Camiseta de algodon talle M', 'price' => 19.99, 'stock_quantity' => 40, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-108', 'barcode' => '8471234568022', 'sku' => 'SKU-TSHIRT-WHT-L', 'name' => 'Camiseta Blanca Basica L', 'description' => 'Camiseta de algodon talle L', 'price' => 19.99, 'stock_quantity' => 33, 'unit' => 'unidad', 'status' => 'active'],

            ['category_code' => 'CAT-109', 'barcode' => '8471234568023', 'sku' => 'SKU-JEANS-BLU-32', 'name' => 'Jeans Azul Oscuro 32', 'description' => 'Jean clasico azul oscuro', 'price' => 59.99, 'stock_quantity' => 18, 'unit' => 'unidad', 'status' => 'active'],
            ['category_code' => 'CAT-109', 'barcode' => '8471234568024', 'sku' => 'SKU-JOGGER-GRY-M', 'name' => 'Jogger Gris M', 'description' => 'Pantalon jogger para uso diario', 'price' => 34.90, 'stock_quantity' => 3, 'unit' => 'unidad', 'status' => 'active'],
        ];

        $productsBySku = [];
        foreach ($products as $productData) {
            $category = $categoriesByCode[$productData['category_code']];
            $product = Product::updateOrCreate(
                ['barcode' => $productData['barcode']],
                [
                    'category_id' => $category->id,
                    'sku' => $productData['sku'],
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'unit' => $productData['unit'],
                    'status' => $productData['status'],
                ]
            );
            $productsBySku[$productData['sku']] = $product;
        }

        $suppliers = [
            [
                'code' => 'SUP-001',
                'tax_id' => '20111111119',
                'business_name' => 'Distribuidora Andina SAC',
                'trade_name' => 'Andina Tech',
                'contact_name' => 'Mariana Paredes',
                'email' => 'compras@andinadistribucion.com',
                'phone' => '+593-123-123-121',
                'address' => 'Av. Primavera 1234',
                'city' => 'Guayaquil',
                'payment_terms' => 'Credito 30 dias',
                'notes' => 'Proveedor principal de tecnologia',
                'status' => 'active',
            ],
            [
                'code' => 'SUP-002',
                'tax_id' => '20111111120',
                'business_name' => 'Ferretera Integral SRL',
                'trade_name' => 'FerreTotal',
                'contact_name' => 'Carlos Mena',
                'email' => 'ventas@ferretotal.com',
                'phone' => '+593-223-133-122',
                'address' => 'Jr. Industrial 458',
                'city' => 'Manta',
                'payment_terms' => 'Credito 15 dias',
                'notes' => 'Especialistas en herramientas y hogar',
                'status' => 'active',
            ],
            [
                'code' => 'SUP-003',
                'tax_id' => '20111111121',
                'business_name' => 'Consumo Masivo del Pacifico',
                'trade_name' => 'PaciFoods',
                'contact_name' => 'Andrea Vega',
                'email' => 'pedido@pacifoods.com',
                'phone' => '+593-999-333-333',
                'address' => 'Calle Comercio 789',
                'city' => 'Quito',
                'payment_terms' => 'Contado',
                'notes' => 'Entrega semanal para bebidas y snacks',
                'status' => 'active',
            ],
        ];

        $suppliersByCode = [];
        foreach ($suppliers as $supplierData) {
            $supplier = Supplier::updateOrCreate(
                ['code' => $supplierData['code']],
                $supplierData
            );
            $suppliersByCode[$supplierData['code']] = $supplier;
        }

        $supplierProducts = [
            ['supplier_code' => 'SUP-001', 'sku' => 'SKU-DELL-001', 'supplier_sku' => 'AT-DX13', 'purchase_price' => 1089.00, 'min_order_qty' => 2, 'lead_time_days' => 7, 'is_preferred' => true],
            ['supplier_code' => 'SUP-001', 'sku' => 'SKU-HP-001', 'supplier_sku' => 'AT-HP15', 'purchase_price' => 625.00, 'min_order_qty' => 2, 'lead_time_days' => 6, 'is_preferred' => true],
            ['supplier_code' => 'SUP-001', 'sku' => 'SKU-IPHONE-13', 'supplier_sku' => 'AT-IP13P', 'purchase_price' => 865.00, 'min_order_qty' => 1, 'lead_time_days' => 5, 'is_preferred' => true],
            ['supplier_code' => 'SUP-001', 'sku' => 'SKU-SAMSUNG-S21', 'supplier_sku' => 'AT-S21', 'purchase_price' => 690.00, 'min_order_qty' => 1, 'lead_time_days' => 5, 'is_preferred' => false],
            ['supplier_code' => 'SUP-001', 'sku' => 'SKU-AUDIO-SONY', 'supplier_sku' => 'AT-WH1000', 'purchase_price' => 272.00, 'min_order_qty' => 2, 'lead_time_days' => 7, 'is_preferred' => true],

            ['supplier_code' => 'SUP-002', 'sku' => 'SKU-HAMMER-001', 'supplier_sku' => 'FT-HM16', 'purchase_price' => 17.50, 'min_order_qty' => 12, 'lead_time_days' => 3, 'is_preferred' => true],
            ['supplier_code' => 'SUP-002', 'sku' => 'SKU-DRILL-001', 'supplier_sku' => 'FT-DW18V', 'purchase_price' => 112.50, 'min_order_qty' => 4, 'lead_time_days' => 4, 'is_preferred' => true],
            ['supplier_code' => 'SUP-002', 'sku' => 'SKU-SCREW-SET', 'supplier_sku' => 'FT-SSET8', 'purchase_price' => 13.20, 'min_order_qty' => 10, 'lead_time_days' => 2, 'is_preferred' => true],
            ['supplier_code' => 'SUP-002', 'sku' => 'SKU-LAMP-DESK', 'supplier_sku' => 'FT-LAMP', 'purchase_price' => 28.00, 'min_order_qty' => 6, 'lead_time_days' => 3, 'is_preferred' => false],

            ['supplier_code' => 'SUP-003', 'sku' => 'SKU-COLA-2L', 'supplier_sku' => 'PF-COLA2', 'purchase_price' => 1.88, 'min_order_qty' => 24, 'lead_time_days' => 2, 'is_preferred' => true],
            ['supplier_code' => 'SUP-003', 'sku' => 'SKU-JUICE-1L', 'supplier_sku' => 'PF-JN1L', 'purchase_price' => 2.25, 'min_order_qty' => 18, 'lead_time_days' => 2, 'is_preferred' => true],
            ['supplier_code' => 'SUP-003', 'sku' => 'SKU-CHIPS-100G', 'supplier_sku' => 'PF-CH100', 'purchase_price' => 0.92, 'min_order_qty' => 50, 'lead_time_days' => 1, 'is_preferred' => true],
            ['supplier_code' => 'SUP-003', 'sku' => 'SKU-COOKIES-90G', 'supplier_sku' => 'PF-CK90', 'purchase_price' => 1.10, 'min_order_qty' => 40, 'lead_time_days' => 1, 'is_preferred' => true],
        ];

        foreach ($supplierProducts as $pivotData) {
            $supplier = $suppliersByCode[$pivotData['supplier_code']] ?? null;
            $product = $productsBySku[$pivotData['sku']] ?? null;

            if (!$supplier || !$product) {
                continue;
            }

            SupplierProduct::updateOrCreate(
                [
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                ],
                [
                    'supplier_sku' => $pivotData['supplier_sku'],
                    'purchase_price' => $pivotData['purchase_price'],
                    'min_order_qty' => $pivotData['min_order_qty'],
                    'lead_time_days' => $pivotData['lead_time_days'],
                    'is_preferred' => $pivotData['is_preferred'],
                    'notes' => null,
                ]
            );
        }

        $purchasingUser = User::where('email', 'admin@tienda.local')->first()
            ?? User::where('email', 'superadmin@tienda.local')->first()
            ?? User::first();

        if ($purchasingUser) {
            $purchaseOrders = [
                [
                    'order_number' => 'PO-2026-0001',
                    'supplier_code' => 'SUP-001',
                    'status' => 'received',
                    'tax_rate' => 18,
                    'shipping_cost' => 35.00,
                    'expected_date' => now()->addDays(7)->toDateString(),
                    'notes' => 'Reposicion de tecnologia',
                    'approved_by' => $purchasingUser->id,
                    'approved_at' => now()->subDays(10),
                    'items' => [
                        ['sku' => 'SKU-DELL-001', 'unit_price' => 1089.00, 'qty_ordered' => 4, 'qty_received' => 4],
                        ['sku' => 'SKU-HP-001', 'unit_price' => 625.00, 'qty_ordered' => 6, 'qty_received' => 6],
                        ['sku' => 'SKU-AUDIO-SONY', 'unit_price' => 272.00, 'qty_ordered' => 5, 'qty_received' => 5],
                    ],
                    'receipts' => [
                        [
                            'receipt_number' => 'GR-2026-0001',
                            'received_at' => now()->subDays(6),
                            'notes' => 'Recepcion completa y conforme',
                            'items' => [
                                ['sku' => 'SKU-DELL-001', 'qty' => 4],
                                ['sku' => 'SKU-HP-001', 'qty' => 6],
                                ['sku' => 'SKU-AUDIO-SONY', 'qty' => 5],
                            ],
                        ],
                    ],
                ],
                [
                    'order_number' => 'PO-2026-0002',
                    'supplier_code' => 'SUP-002',
                    'status' => 'partial',
                    'tax_rate' => 18,
                    'shipping_cost' => 18.00,
                    'expected_date' => now()->addDays(4)->toDateString(),
                    'notes' => 'Herramientas para temporada alta',
                    'approved_by' => $purchasingUser->id,
                    'approved_at' => now()->subDays(4),
                    'items' => [
                        ['sku' => 'SKU-DRILL-001', 'unit_price' => 112.50, 'qty_ordered' => 8, 'qty_received' => 3],
                        ['sku' => 'SKU-HAMMER-001', 'unit_price' => 17.50, 'qty_ordered' => 30, 'qty_received' => 30],
                        ['sku' => 'SKU-SCREW-SET', 'unit_price' => 13.20, 'qty_ordered' => 20, 'qty_received' => 0],
                    ],
                    'receipts' => [
                        [
                            'receipt_number' => 'GR-2026-0002',
                            'received_at' => now()->subDays(2),
                            'notes' => 'Ingreso parcial por quiebre de stock',
                            'items' => [
                                ['sku' => 'SKU-DRILL-001', 'qty' => 3],
                                ['sku' => 'SKU-HAMMER-001', 'qty' => 30],
                            ],
                        ],
                    ],
                ],
                [
                    'order_number' => 'PO-2026-0003',
                    'supplier_code' => 'SUP-003',
                    'status' => 'pending',
                    'tax_rate' => 0,
                    'shipping_cost' => 0,
                    'expected_date' => now()->addDays(2)->toDateString(),
                    'notes' => 'Reposicion rapida de snacks y bebidas',
                    'approved_by' => $purchasingUser->id,
                    'approved_at' => now()->subDay(),
                    'items' => [
                        ['sku' => 'SKU-COLA-2L', 'unit_price' => 1.88, 'qty_ordered' => 72, 'qty_received' => 0],
                        ['sku' => 'SKU-CHIPS-100G', 'unit_price' => 0.92, 'qty_ordered' => 120, 'qty_received' => 0],
                        ['sku' => 'SKU-COOKIES-90G', 'unit_price' => 1.10, 'qty_ordered' => 90, 'qty_received' => 0],
                    ],
                    'receipts' => [],
                ],
            ];

            foreach ($purchaseOrders as $orderData) {
                $supplier = $suppliersByCode[$orderData['supplier_code']] ?? null;
                if (!$supplier) {
                    continue;
                }

                $order = PurchaseOrder::updateOrCreate(
                    ['order_number' => $orderData['order_number']],
                    [
                        'supplier_id' => $supplier->id,
                        'user_id' => $purchasingUser->id,
                        'status' => $orderData['status'],
                        'tax_rate' => $orderData['tax_rate'],
                        'shipping_cost' => $orderData['shipping_cost'],
                        'expected_date' => $orderData['expected_date'],
                        'notes' => $orderData['notes'],
                        'approved_by' => $orderData['approved_by'],
                        'approved_at' => $orderData['approved_at'],
                    ]
                );

                $subtotal = 0;
                foreach ($orderData['items'] as $itemData) {
                    $product = $productsBySku[$itemData['sku']] ?? null;
                    if (!$product) {
                        continue;
                    }

                    $lineSubtotal = round($itemData['unit_price'] * $itemData['qty_ordered'], 2);
                    $subtotal += $lineSubtotal;

                    PurchaseOrderItem::updateOrCreate(
                        [
                            'purchase_order_id' => $order->id,
                            'product_id' => $product->id,
                        ],
                        [
                            'product_name' => $product->name,
                            'unit_price' => $itemData['unit_price'],
                            'quantity_ordered' => $itemData['qty_ordered'],
                            'quantity_received' => $itemData['qty_received'],
                            'unit' => $product->unit,
                            'subtotal' => $lineSubtotal,
                        ]
                    );
                }

                $taxTotal = round(($subtotal * $orderData['tax_rate']) / 100, 2);
                $total = round($subtotal + $taxTotal + $orderData['shipping_cost'], 2);

                $order->update([
                    'subtotal' => $subtotal,
                    'tax_total' => $taxTotal,
                    'total' => $total,
                ]);

                foreach ($orderData['receipts'] as $receiptData) {
                    $receipt = PurchaseReceipt::updateOrCreate(
                        ['receipt_number' => $receiptData['receipt_number']],
                        [
                            'purchase_order_id' => $order->id,
                            'user_id' => $purchasingUser->id,
                            'received_at' => $receiptData['received_at'],
                            'notes' => $receiptData['notes'],
                        ]
                    );

                    foreach ($receiptData['items'] as $receiptItemData) {
                        $product = $productsBySku[$receiptItemData['sku']] ?? null;
                        if (!$product) {
                            continue;
                        }

                        $poItem = PurchaseOrderItem::where('purchase_order_id', $order->id)
                            ->where('product_id', $product->id)
                            ->first();

                        if (!$poItem) {
                            continue;
                        }

                        PurchaseReceiptItem::updateOrCreate(
                            [
                                'purchase_receipt_id' => $receipt->id,
                                'purchase_order_item_id' => $poItem->id,
                            ],
                            [
                                'product_id' => $product->id,
                                'quantity_received' => $receiptItemData['qty'],
                                'notes' => null,
                            ]
                        );
                    }
                }
            }
        }

        echo "DemoDataSeeder ejecutado: zonas, categorias, productos, proveedores y compras demo creados o actualizados.\n";
    }
}
