<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('inventario_item_id')->constrained('inventario_items')->onDelete('cascade');
            $table->string('nombre_item')->nullable();
            $table->string('codigo_serie')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};