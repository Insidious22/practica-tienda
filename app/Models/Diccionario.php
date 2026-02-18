<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Diccionario extends Model
{
    protected $table = 'diccionario';

    public const TIPO_GUARDIA_TIPO_DOCUMENTO = 'GTD';
    public const TIPO_GUARDIA_TURNO = 'GTR';
    public const TIPO_PRODUCTO_ESTADO = 'PES';
    public const TIPO_PRODUCTO_UNIDAD = 'PUN';
    public const TIPO_PROVEEDOR_ESTADO = 'PVE';
    public const TIPO_CLIENTE_TIPO_DOCUMENTO = 'CTD';

    private const TIPO_ALIAS = [
        'guardia_tipo_documento' => self::TIPO_GUARDIA_TIPO_DOCUMENTO,
        'guardia_turno' => self::TIPO_GUARDIA_TURNO,
        'producto_estado' => self::TIPO_PRODUCTO_ESTADO,
        'producto_unidad' => self::TIPO_PRODUCTO_UNIDAD,
        'proveedor_estado' => self::TIPO_PROVEEDOR_ESTADO,
        'cliente_tipo_documento' => self::TIPO_CLIENTE_TIPO_DOCUMENTO,
    ];
    private const TIPO_LABELS = [
        self::TIPO_GUARDIA_TIPO_DOCUMENTO => 'Guardia - Tipo de documento',
        self::TIPO_GUARDIA_TURNO => 'Guardia - Turno',
        self::TIPO_PRODUCTO_ESTADO => 'Producto - Estado',
        self::TIPO_PRODUCTO_UNIDAD => 'Producto - Unidad',
        self::TIPO_PROVEEDOR_ESTADO => 'Proveedor - Estado',
        self::TIPO_CLIENTE_TIPO_DOCUMENTO => 'Cliente - Tipo de documento',
    ];

    protected $fillable = [
        'orden',
        'id_cliente',
        'tabla',
        'valor',
        'descripcion',
        'estado',
    ];

    private static array $cache = [];

    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            $model->tabla = self::tipoKey((string) $model->tabla);
            $model->descripcion = trim((string) $model->descripcion);
            $model->valor = self::resolverValor($model->valor, $model->descripcion);

            $estado = strtoupper(trim((string) ($model->estado ?? 'A')));
            $model->estado = in_array($estado, ['A', 'I'], true) ? $estado : 'A';
        });
    }

    public function scopePorTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tabla', self::tipoKey($tipo))
            ->where('estado', 'A');
    }

    public static function opciones(string $tipo): Collection
    {
        $tipoKey = self::tipoKey($tipo);

        if (!isset(self::$cache[$tipoKey])) {
            self::$cache[$tipoKey] = self::query()
                ->where('tabla', $tipoKey)
                ->where('estado', 'A')
                ->orderBy('orden')
                ->get(['orden as numero', 'valor as siglas', 'descripcion']);
        }

        return self::$cache[$tipoKey];
    }

    public static function numeroDeSigla(string $tipo, ?string $sigla): ?int
    {
        if ($sigla === null || $sigla === '') {
            return null;
        }

        $registro = self::opciones($tipo)->firstWhere('siglas', strtoupper($sigla));
        return $registro?->numero;
    }

    public static function siglaDeNumero(string $tipo, mixed $numero): ?string
    {
        if ($numero === null || $numero === '') {
            return null;
        }

        $registro = self::opciones($tipo)->firstWhere('numero', (int) $numero);
        return $registro?->siglas;
    }

    public static function siglas(string $tipo): array
    {
        return self::opciones($tipo)->pluck('siglas')->all();
    }

    public function getNumeroAttribute(): ?int
    {
        return $this->attributes['orden'] ?? null;
    }

    public function setNumeroAttribute(mixed $value): void
    {
        $this->attributes['orden'] = $value;
    }

    public function getTipoAttribute(): ?string
    {
        return $this->attributes['tabla'] ?? null;
    }

    public function setTipoAttribute(mixed $value): void
    {
        $this->attributes['tabla'] = self::tipoKey((string) $value);
    }

    public function getSiglasAttribute(): ?string
    {
        return $this->attributes['valor'] ?? null;
    }

    public function setSiglasAttribute(mixed $value): void
    {
        $this->attributes['valor'] = self::normalizarValor((string) $value);
    }

    public static function tipoKey(string $tipo): string
    {
        $normalized = strtolower(trim($tipo));
        return self::TIPO_ALIAS[$normalized] ?? strtoupper(trim($tipo));
    }

    public static function tipoLabel(string $tipo): string
    {
        $tipoKey = self::tipoKey($tipo);
        return self::TIPO_LABELS[$tipoKey] ?? $tipoKey;
    }

    public static function tiposConocidos(): array
    {
        return self::TIPO_LABELS;
    }

    public static function resolverValor(mixed $valor, mixed $descripcion): string
    {
        $valorNormalizado = self::normalizarValor((string) ($valor ?? ''));
        if ($valorNormalizado !== '') {
            return $valorNormalizado;
        }

        return self::generarValorDesdeDescripcion((string) ($descripcion ?? ''));
    }

    public static function generarValorDesdeDescripcion(string $descripcion): string
    {
        $limpio = self::normalizarTexto($descripcion);
        if ($limpio === '') {
            return '';
        }

        $palabras = preg_split('/\s+/', $limpio, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        if (count($palabras) <= 1) {
            return substr($palabras[0] ?? '', 0, 3);
        }

        $iniciales = '';
        foreach ($palabras as $palabra) {
            if ($palabra === '') {
                continue;
            }
            $iniciales .= substr($palabra, 0, 1);
            if (strlen($iniciales) === 4) {
                break;
            }
        }

        return $iniciales;
    }

    public static function normalizarValor(string $valor): string
    {
        $texto = self::normalizarTexto($valor);
        return preg_replace('/[^A-Z0-9]/', '', $texto) ?? '';
    }

    private static function normalizarTexto(string $texto): string
    {
        $sinTildes = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', trim($texto));
        $sinTildes = $sinTildes === false ? trim($texto) : $sinTildes;
        $sinTildes = strtoupper($sinTildes);
        $sinTildes = preg_replace('/[^A-Z0-9 ]/', ' ', $sinTildes) ?? '';
        return trim(preg_replace('/\s+/', ' ', $sinTildes) ?? '');
    }
}
