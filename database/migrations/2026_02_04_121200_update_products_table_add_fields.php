<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Relación a categoría (1:N)
            $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->onDelete('restrict')->onUpdate('cascade');

            // Código de barras manual y único
            $table->string('barcode', 64)->unique()->nullable()->after('category_id');

            // SKU opcional y unidad
            $table->string('sku', 64)->nullable()->after('barcode');
            $table->string('unit', 32)->default('unidad')->after('sku');

            // stock_quantity como decimal para permitir fracciones (ej. kg)
            $table->decimal('stock_quantity', 15, 3)->default(0)->after('stock');

            // estado del producto
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active')->after('stock_quantity');

            // Nota: mantenemos la columna `stock` antigua para compatibilidad; puede migrarse y eliminarse en otra migración.
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'barcode', 'sku', 'unit', 'stock_quantity', 'status']);
        });
    }
};
