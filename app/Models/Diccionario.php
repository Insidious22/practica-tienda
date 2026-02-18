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

    protected $fillable = [
        'numero',
        'tipo',
        'descripcion',
        'siglas',
    ];

    private static array $cache = [];

    public function setTipoAttribute(string $value): void
    {
        $this->attributes['tipo'] = self::tipoKey($value);
    }

    public function scopePorTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo', self::tipoKey($tipo));
    }

    public static function opciones(string $tipo): Collection
    {
        $tipoKey = self::tipoKey($tipo);

        if (!isset(self::$cache[$tipoKey])) {
            self::$cache[$tipoKey] = self::query()
                ->where('tipo', $tipoKey)
                ->orderBy('numero')
                ->get(['numero', 'siglas', 'descripcion']);
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

    public static function tipoKey(string $tipo): string
    {
        $normalized = strtolower(trim($tipo));
        return self::TIPO_ALIAS[$normalized] ?? strtoupper(trim($tipo));
    }
}
