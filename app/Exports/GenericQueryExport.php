<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GenericQueryExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        private readonly string $dataset,
        private readonly string $startDate,
        private readonly string $endDate,
    ) {
    }

    public function query(): Builder
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        return (match ($this->dataset) {
            'categorias' => Category::query()->with('zone'),
            'productos' => Product::query()->with('category'),
            'zonas' => Zone::query(),
            'proveedores' => Supplier::query(),
            'usuarios' => User::query(),
            'clientes' => User::query()->whereHas('roles', fn ($q) => $q->where('code', 'customer')),
            default => throw new \InvalidArgumentException('Dataset no soportado.'),
        })
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at');
    }

    public function headings(): array
    {
        return match ($this->dataset) {
            'categorias' => ['id', 'zona', 'nombre', 'codigo', 'descripcion', 'fecha_creacion'],
            'productos' => ['id', 'categoria', 'nombre', 'codigo_barras', 'precio', 'stock_cantidad', 'unidad', 'estado', 'fecha_creacion'],
            'zonas' => ['id', 'codigo', 'nombre', 'descripcion', 'fecha_creacion'],
            'proveedores' => ['id', 'codigo', 'razon_social', 'nombre_comercial', 'contacto', 'telefono', 'email', 'ciudad', 'estado', 'fecha_creacion'],
            'usuarios' => ['id', 'nombre', 'email', 'telefono', 'ciudad', 'documento', 'fecha_creacion'],
            'clientes' => ['id', 'nombre', 'email', 'telefono', 'ciudad', 'documento', 'fecha_creacion'],
            default => [],
        };
    }

    public function map($row): array
    {
        $values = match ($this->dataset) {
            'categorias' => [
                $row->id,
                $row->zone->name ?? '',
                $row->name,
                $row->code,
                $row->description,
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            'productos' => [
                $row->id,
                $row->category->name ?? '',
                $row->name,
                $row->barcode,
                $row->price,
                $row->stock_quantity,
                $row->unit,
                $row->status,
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            'zonas' => [
                $row->id,
                $row->code,
                $row->name,
                $row->description,
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            'proveedores' => [
                $row->id,
                $row->code,
                $row->business_name,
                $row->trade_name,
                $row->contact_name,
                $row->phone,
                $row->email,
                $row->city,
                $row->status,
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            'usuarios' => [
                $row->id,
                $row->name,
                $row->email,
                $row->phone,
                $row->city,
                trim((string) ($row->document_type . ' ' . $row->document_number)),
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            'clientes' => [
                $row->id,
                $row->name,
                $row->email,
                $row->phone,
                $row->city,
                trim((string) ($row->document_type . ' ' . $row->document_number)),
                optional($row->created_at)->format('Y-m-d H:i:s'),
            ],
            default => [],
        };

        return array_map(fn ($value) => $this->sanitizeCell($value), $values);
    }

    private function sanitizeCell(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        $first = ltrim($value)[0] ?? '';
        if (in_array($first, ['=', '+', '-', '@'], true)) {
            return "'".$value;
        }

        return $value;
    }
}
