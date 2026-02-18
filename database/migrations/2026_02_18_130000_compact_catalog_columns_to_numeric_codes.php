<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->compactProducts();
        $this->compactGuardias();
        $this->compactUsers();
    }

    public function down(): void
    {
        $this->restoreProducts();
        $this->restoreGuardias();
        $this->restoreUsers();
    }

    private function compactProducts(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'unit') || !Schema::hasColumn('products', 'status')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedTinyInteger('unit_tmp')->nullable()->after('unit');
            $table->unsignedTinyInteger('status_tmp')->nullable()->after('status');
        });

        DB::statement("
            UPDATE products p
            LEFT JOIN diccionario du ON du.tipo = 'producto_unidad' AND du.siglas = p.unit
            LEFT JOIN diccionario ds ON ds.tipo = 'producto_estado' AND ds.siglas = p.status
            SET
                p.unit_tmp = COALESCE(du.numero, 1),
                p.status_tmp = COALESCE(ds.numero, 1)
        ");

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'status']);
        });

        DB::statement("
            ALTER TABLE products
            CHANGE unit_tmp unit TINYINT UNSIGNED NOT NULL DEFAULT 1,
            CHANGE status_tmp status TINYINT UNSIGNED NOT NULL DEFAULT 1
        ");
    }

    private function compactGuardias(): void
    {
        if (!Schema::hasTable('guardias') || !Schema::hasColumn('guardias', 'tipo_documento') || !Schema::hasColumn('guardias', 'turno')) {
            return;
        }

        Schema::table('guardias', function (Blueprint $table) {
            $table->unsignedTinyInteger('tipo_documento_tmp')->nullable()->after('tipo_documento');
            $table->unsignedTinyInteger('turno_tmp')->nullable()->after('turno');
        });

        DB::statement("
            UPDATE guardias g
            LEFT JOIN diccionario dt ON dt.tipo = 'guardia_tipo_documento' AND dt.siglas = g.tipo_documento
            LEFT JOIN diccionario tt ON tt.tipo = 'guardia_turno' AND tt.siglas = g.turno
            SET
                g.tipo_documento_tmp = COALESCE(dt.numero, 1),
                g.turno_tmp = COALESCE(tt.numero, 1)
        ");

        Schema::table('guardias', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'turno']);
        });

        DB::statement("
            ALTER TABLE guardias
            CHANGE tipo_documento_tmp tipo_documento TINYINT UNSIGNED NOT NULL DEFAULT 1,
            CHANGE turno_tmp turno TINYINT UNSIGNED NOT NULL DEFAULT 1
        ");
    }

    private function compactUsers(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'document_type')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('document_type_tmp')->nullable()->after('document_type');
        });

        DB::statement("
            UPDATE users u
            LEFT JOIN diccionario dc ON dc.tipo = 'cliente_tipo_documento' AND dc.siglas = u.document_type
            SET u.document_type_tmp = dc.numero
        ");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });

        DB::statement("
            ALTER TABLE users
            CHANGE document_type_tmp document_type TINYINT UNSIGNED NULL
        ");
    }

    private function restoreProducts(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'unit') || !Schema::hasColumn('products', 'status')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->string('unit_txt', 32)->nullable()->after('unit');
            $table->string('status_txt', 10)->nullable()->after('status');
        });

        DB::statement("
            UPDATE products p
            LEFT JOIN diccionario du ON du.tipo = 'producto_unidad' AND du.numero = p.unit
            LEFT JOIN diccionario ds ON ds.tipo = 'producto_estado' AND ds.numero = p.status
            SET
                p.unit_txt = COALESCE(du.siglas, 'UNI'),
                p.status_txt = COALESCE(ds.siglas, 'ACT')
        ");

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'status']);
        });

        DB::statement("
            ALTER TABLE products
            CHANGE unit_txt unit VARCHAR(32) NOT NULL,
            CHANGE status_txt status VARCHAR(10) NOT NULL
        ");
    }

    private function restoreGuardias(): void
    {
        if (!Schema::hasTable('guardias') || !Schema::hasColumn('guardias', 'tipo_documento') || !Schema::hasColumn('guardias', 'turno')) {
            return;
        }

        Schema::table('guardias', function (Blueprint $table) {
            $table->string('tipo_documento_txt', 20)->nullable()->after('tipo_documento');
            $table->string('turno_txt', 20)->nullable()->after('turno');
        });

        DB::statement("
            UPDATE guardias g
            LEFT JOIN diccionario dt ON dt.tipo = 'guardia_tipo_documento' AND dt.numero = g.tipo_documento
            LEFT JOIN diccionario tt ON tt.tipo = 'guardia_turno' AND tt.numero = g.turno
            SET
                g.tipo_documento_txt = COALESCE(dt.siglas, 'CED'),
                g.turno_txt = COALESCE(tt.siglas, 'MAN')
        ");

        Schema::table('guardias', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'turno']);
        });

        DB::statement("
            ALTER TABLE guardias
            CHANGE tipo_documento_txt tipo_documento VARCHAR(20) NOT NULL,
            CHANGE turno_txt turno VARCHAR(20) NOT NULL
        ");
    }

    private function restoreUsers(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'document_type')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('document_type_txt', 10)->nullable()->after('document_type');
        });

        DB::statement("
            UPDATE users u
            LEFT JOIN diccionario dc ON dc.tipo = 'cliente_tipo_documento' AND dc.numero = u.document_type
            SET u.document_type_txt = dc.siglas
        ");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });

        DB::statement("
            ALTER TABLE users
            CHANGE document_type_txt document_type VARCHAR(10) NULL
        ");
    }
};
