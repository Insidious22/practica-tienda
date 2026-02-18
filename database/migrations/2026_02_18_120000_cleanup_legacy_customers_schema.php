<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sales_orders') && Schema::hasColumn('sales_orders', 'customer_id')) {
            Schema::table('sales_orders', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            });
        }

        Schema::dropIfExists('customers');
    }

    public function down(): void
    {
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('code', 32)->unique();
                $table->enum('document_type', ['dni', 'ruc', 'ce', 'passport'])->nullable();
                $table->string('document_number', 20)->nullable();
                $table->string('name', 255);
                $table->string('email', 255)->nullable();
                $table->string('phone', 32)->nullable();
                $table->text('address')->nullable();
                $table->string('city', 128)->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();

                $table->unique(['document_type', 'document_number']);
                $table->index('status');
            });
        }

        if (Schema::hasTable('sales_orders') && !Schema::hasColumn('sales_orders', 'customer_id')) {
            Schema::table('sales_orders', function (Blueprint $table) {
                $table->foreignId('customer_id')->nullable()->after('order_number')
                    ->constrained('customers')->nullOnDelete()->cascadeOnUpdate();
            });
        }
    }
};
