<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('diccionario')) {
            Schema::create('diccionario', function (Blueprint $table) {
                $table->id();
                $table->integer('orden');
                $table->unsignedBigInteger('id_cliente')->nullable();
                $table->string('tabla');
                $table->string('valor');
                $table->string('descripcion');
                $table->char('estado', 1)->default('A');
                $table->timestamps();

                $table->unique(['tabla', 'orden']);
                $table->unique(['tabla', 'valor']);
                $table->index('tabla');
            });

            return;
        }

        if (Schema::hasColumn('diccionario', 'numero')) {
            DB::statement('ALTER TABLE diccionario CHANGE numero orden INT NOT NULL');
        }
        if (Schema::hasColumn('diccionario', 'tipo')) {
            DB::statement('ALTER TABLE diccionario CHANGE tipo tabla VARCHAR(255) NOT NULL');
        }
        if (Schema::hasColumn('diccionario', 'siglas')) {
            DB::statement('ALTER TABLE diccionario CHANGE siglas valor VARCHAR(255) NULL');
        }

        Schema::table('diccionario', function (Blueprint $table) {
            if (!Schema::hasColumn('diccionario', 'orden')) {
                $table->integer('orden')->after('id');
            }
            if (!Schema::hasColumn('diccionario', 'id_cliente')) {
                $table->unsignedBigInteger('id_cliente')->nullable()->after('orden');
            }
            if (!Schema::hasColumn('diccionario', 'tabla')) {
                $table->string('tabla')->after('id_cliente');
            }
            if (!Schema::hasColumn('diccionario', 'valor')) {
                $table->string('valor')->nullable()->after('tabla');
            }
            if (!Schema::hasColumn('diccionario', 'descripcion')) {
                $table->string('descripcion')->after('valor');
            }
            if (!Schema::hasColumn('diccionario', 'estado')) {
                $table->char('estado', 1)->default('A')->after('descripcion');
            }
            if (!Schema::hasColumn('diccionario', 'created_at')) {
                $table->timestamps();
            }
        });

        DB::table('diccionario')->update([
            'tabla' => DB::raw('UPPER(TRIM(tabla))'),
            'estado' => DB::raw("CASE WHEN UPPER(TRIM(COALESCE(estado, 'A'))) = 'I' THEN 'I' ELSE 'A' END"),
            'descripcion' => DB::raw('TRIM(descripcion)'),
        ]);

        $sinValor = DB::table('diccionario')
            ->select(['id', 'descripcion'])
            ->whereNull('valor')
            ->orWhere('valor', '')
            ->get();

        foreach ($sinValor as $registro) {
            $valor = $this->generarValorDesdeDescripcion((string) $registro->descripcion);
            if ($valor === '') {
                $valor = 'VAL' . $registro->id;
            }

            DB::table('diccionario')
                ->where('id', $registro->id)
                ->update(['valor' => $valor]);
        }

        DB::table('diccionario')->update([
            'valor' => DB::raw('UPPER(TRIM(valor))'),
        ]);

        DB::statement('ALTER TABLE diccionario MODIFY valor VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE diccionario MODIFY descripcion VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE diccionario MODIFY tabla VARCHAR(255) NOT NULL');
        DB::statement("ALTER TABLE diccionario MODIFY estado CHAR(1) NOT NULL DEFAULT 'A'");

        $this->dropUniqueIndexes('diccionario');

        Schema::table('diccionario', function (Blueprint $table) {
            $table->unique(['tabla', 'orden']);
            $table->unique(['tabla', 'valor']);
            $table->index('tabla');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('diccionario')) {
            return;
        }

        $this->dropIndexIfExists('diccionario', 'diccionario_tabla_orden_unique');
        $this->dropIndexIfExists('diccionario', 'diccionario_tabla_valor_unique');
        $this->dropIndexIfExists('diccionario', 'diccionario_tabla_index');

        if (Schema::hasColumn('diccionario', 'valor')) {
            DB::statement('ALTER TABLE diccionario CHANGE valor siglas VARCHAR(30) NOT NULL');
        }
        if (Schema::hasColumn('diccionario', 'tabla')) {
            DB::statement('ALTER TABLE diccionario CHANGE tabla tipo VARCHAR(100) NOT NULL');
        }
        if (Schema::hasColumn('diccionario', 'orden')) {
            DB::statement('ALTER TABLE diccionario CHANGE orden numero INT NOT NULL');
        }

        Schema::table('diccionario', function (Blueprint $table) {
            if (Schema::hasColumn('diccionario', 'id_cliente')) {
                $table->dropColumn('id_cliente');
            }
            if (Schema::hasColumn('diccionario', 'estado')) {
                $table->dropColumn('estado');
            }

            $table->unique(['tipo', 'numero']);
            $table->unique(['tipo', 'siglas']);
            $table->unique(['tipo', 'descripcion']);
            $table->index('tipo');
        });
    }

    private function dropUniqueIndexes(string $table): void
    {
        $indexes = DB::select(
            "SELECT DISTINCT INDEX_NAME
             FROM information_schema.statistics
             WHERE table_schema = DATABASE()
               AND table_name = ?
               AND NON_UNIQUE = 0
               AND INDEX_NAME <> 'PRIMARY'",
            [$table]
        );

        foreach ($indexes as $index) {
            $this->dropIndexIfExists($table, $index->INDEX_NAME);
        }
    }

    private function dropIndexIfExists(string $table, string $index): void
    {
        $exists = DB::select(
            "SELECT 1
             FROM information_schema.statistics
             WHERE table_schema = DATABASE()
               AND table_name = ?
               AND index_name = ?
             LIMIT 1",
            [$table, $index]
        );

        if (!empty($exists)) {
            DB::statement("ALTER TABLE {$table} DROP INDEX {$index}");
        }
    }

    private function generarValorDesdeDescripcion(string $descripcion): string
    {
        $normalizado = $this->normalizarTexto($descripcion);
        if ($normalizado === '') {
            return '';
        }

        $palabras = preg_split('/\s+/', $normalizado, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        if (count($palabras) <= 1) {
            return substr($palabras[0] ?? '', 0, 3);
        }

        $iniciales = '';
        foreach ($palabras as $palabra) {
            $iniciales .= substr($palabra, 0, 1);
            if (strlen($iniciales) === 4) {
                break;
            }
        }

        return $iniciales;
    }

    private function normalizarTexto(string $texto): string
    {
        $sinTildes = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', trim($texto));
        $sinTildes = $sinTildes === false ? trim($texto) : $sinTildes;
        $sinTildes = strtoupper($sinTildes);
        $sinTildes = preg_replace('/[^A-Z0-9 ]/', ' ', $sinTildes) ?? '';
        return trim(preg_replace('/\s+/', ' ', $sinTildes) ?? '');
    }
};
