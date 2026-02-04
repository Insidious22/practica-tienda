<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->string('supplier_sku', 64)->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('min_order_qty', 15, 3)->default(1);
            $table->integer('lead_time_days')->nullable();
            $table->boolean('is_preferred')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['supplier_id', 'product_id']);
            $table->index('is_preferred');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};
