<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_receipt_id')->constrained('purchase_receipts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('purchase_order_item_id')->constrained('purchase_order_items')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('quantity_received', 15, 3);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('purchase_receipt_id');
            $table->index('purchase_order_item_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_receipt_items');
    }
};
