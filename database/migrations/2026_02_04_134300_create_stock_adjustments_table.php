<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('adjustment_number', 32)->unique();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->onDelete('set null')->onUpdate('cascade');
            $table->enum('adjustment_type', ['count', 'damage', 'expiry', 'theft', 'other']);
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->onUpdate('cascade');
            $table->timestamp('approved_at')->nullable();
            $table->text('reason');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('zone_id');
            $table->index('adjustment_type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
