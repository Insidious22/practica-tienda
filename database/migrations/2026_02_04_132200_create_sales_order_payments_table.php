<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('reference', 128)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('sales_order_id');
            $table->index('payment_method_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_order_payments');
    }
};
