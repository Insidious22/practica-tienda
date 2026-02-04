<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_number', 32)->unique();
            $table->foreignId('movement_type_id')->constrained('inventory_movement_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('source_zone_id')->nullable()->constrained('zones')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('target_zone_id')->nullable()->constrained('zones')->onDelete('set null')->onUpdate('cascade');
            $table->decimal('quantity', 15, 3);
            $table->string('unit', 32);
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->decimal('stock_before', 15, 3);
            $table->decimal('stock_after', 15, 3);
            $table->string('reference_type', 128)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamp('movement_date');
            $table->timestamps();

            $table->index('movement_type_id');
            $table->index('product_id');
            $table->index('source_zone_id');
            $table->index('target_zone_id');
            $table->index(['reference_type', 'reference_id']);
            $table->index('movement_date');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
