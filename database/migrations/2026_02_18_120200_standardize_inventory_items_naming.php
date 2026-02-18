<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inventario_items') && !Schema::hasTable('inventory_items')) {
            Schema::rename('inventario_items', 'inventory_items');
        }

        if (Schema::hasTable('items') && Schema::hasColumn('items', 'inventario_item_id')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropForeign(['inventario_item_id']);
            });

            DB::statement('ALTER TABLE items CHANGE inventario_item_id inventory_item_id BIGINT UNSIGNED NOT NULL');

            Schema::table('items', function (Blueprint $table) {
                $table->foreign('inventory_item_id')
                    ->references('id')
                    ->on('inventory_items')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('items') && Schema::hasColumn('items', 'inventory_item_id')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropForeign(['inventory_item_id']);
            });

            DB::statement('ALTER TABLE items CHANGE inventory_item_id inventario_item_id BIGINT UNSIGNED NOT NULL');

            Schema::table('items', function (Blueprint $table) {
                $table->foreign('inventario_item_id')
                    ->references('id')
                    ->on('inventario_items')
                    ->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('inventory_items') && !Schema::hasTable('inventario_items')) {
            Schema::rename('inventory_items', 'inventario_items');
        }
    }
};
