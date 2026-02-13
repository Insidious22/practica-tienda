<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diccionario', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero');
            $table->string('tipo', 100);
            $table->string('descripcion', 150);
            $table->string('siglas', 30);
            $table->timestamps();

            $table->unique(['tipo', 'numero']);
            $table->unique(['tipo', 'descripcion']);
            $table->unique(['tipo', 'siglas']);
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diccionario');
    }
};
