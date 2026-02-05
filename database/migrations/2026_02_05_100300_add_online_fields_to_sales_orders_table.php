<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->enum('channel', ['pos', 'online'])->default('pos')->after('status');
            $table->enum('online_status', ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'])
                  ->nullable()->after('channel');
            $table->string('stripe_payment_intent_id')->nullable()->after('online_status');
            $table->string('shipping_address')->nullable()->after('stripe_payment_intent_id');
            $table->string('shipping_city', 100)->nullable()->after('shipping_address');
            $table->string('shipping_postal_code', 20)->nullable()->after('shipping_city');
            $table->text('shipping_notes')->nullable()->after('shipping_postal_code');
            $table->timestamp('shipped_at')->nullable()->after('shipping_notes');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->string('tracking_number', 100)->nullable()->after('delivered_at');

            $table->index('stripe_payment_intent_id');
            $table->index('channel');
            $table->index('online_status');
        });
    }

    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropIndex(['stripe_payment_intent_id']);
            $table->dropIndex(['channel']);
            $table->dropIndex(['online_status']);
            $table->dropColumn([
                'channel',
                'online_status',
                'stripe_payment_intent_id',
                'shipping_address',
                'shipping_city',
                'shipping_postal_code',
                'shipping_notes',
                'shipped_at',
                'delivered_at',
                'tracking_number',
            ]);
        });
    }
};
