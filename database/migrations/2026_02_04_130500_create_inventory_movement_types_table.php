<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movement_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('name', 64);
            $table->enum('direction', ['in', 'out']);
            $table->boolean('affects_stock')->default(true);
            $table->boolean('requires_reference')->default(false);
            $table->boolean('is_system')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('direction');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movement_types');
    }
};
