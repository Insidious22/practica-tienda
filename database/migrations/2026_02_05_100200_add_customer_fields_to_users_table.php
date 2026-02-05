<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('postal_code', 20)->nullable()->after('city');
            $table->string('document_type', 10)->nullable()->after('postal_code');
            $table->string('document_number', 20)->nullable()->after('document_type');
            $table->string('stripe_customer_id')->nullable()->after('document_number');

            $table->index('stripe_customer_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['stripe_customer_id']);
            $table->dropColumn([
                'phone',
                'address',
                'city',
                'postal_code',
                'document_type',
                'document_number',
                'stripe_customer_id',
            ]);
        });
    }
};
