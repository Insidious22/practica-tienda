<?php

namespace App\Services;

use App\Models\Diccionario;
use Illuminate\Support\Collection;

class CatalogOptionService
{
    public function options(string $type, array $fallback = []): Collection
    {
        $items = Diccionario::porTipo($type)->orderBy('orden')->get();

        $normalized = $items
            ->map(function ($item) {
                return (object) [
                    'numero' => (int) ($item->numero ?? $item->orden ?? 0),
                    'descripcion' => trim((string) ($item->descripcion ?? '')),
                    'siglas' => strtoupper(trim((string) ($item->siglas ?? $item->valor ?? ''))),
                ];
            })
            ->filter(fn ($item) => $item->siglas !== '' && $item->descripcion !== '')
            ->values();

        if ($normalized->isNotEmpty()) {
            return $normalized;
        }

        return collect($fallback)
            ->map(function ($item) {
                return (object) [
                    'numero' => (int) ($item['numero'] ?? 0),
                    'descripcion' => trim((string) ($item['descripcion'] ?? '')),
                    'siglas' => strtoupper(trim((string) ($item['siglas'] ?? ''))),
                ];
            })
            ->filter(fn ($item) => $item->siglas !== '' && $item->descripcion !== '')
            ->values();
    }

    public function keys(string $type, array $fallback = []): array
    {
        $keys = collect(Diccionario::siglas($type))
            ->map(fn ($value) => strtoupper(trim((string) $value)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (!empty($keys)) {
            return $keys;
        }

        return collect($fallback)
            ->map(fn ($value) => strtoupper(trim((string) $value)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
