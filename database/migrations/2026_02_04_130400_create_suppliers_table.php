<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('tax_id', 32)->nullable();
            $table->string('business_name', 255);
            $table->string('trade_name', 255)->nullable();
            $table->string('contact_name', 128)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('phone_secondary', 32)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 128)->nullable();
            $table->string('payment_terms', 128)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('tax_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
