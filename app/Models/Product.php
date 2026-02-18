<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
                $count = static::where('slug', 'like', $product->slug . '%')->count();
                if ($count > 0) {
                    $product->slug .= '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    protected $fillable = [
        'category_id',
        'barcode',
        'sku',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'stock_quantity',
        'unit',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'decimal:3',
        'unit' => 'integer',
        'status' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getZoneAttribute()
    {
        return $this->category ? $this->category->zone : null;
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'supplier_products')
            ->withPivot('supplier_sku', 'purchase_price', 'min_order_qty', 'lead_time_days', 'is_preferred', 'notes')
            ->withTimestamps();
    }

    public function salesOrderItems(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where('status', Diccionario::numeroDeSigla('producto_estado', 'ACT') ?? 1);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Diccionario::siglaDeNumero('producto_estado', $value) ?? 'ACT',
            set: function ($value) {
                if ($value === null || $value === '') {
                    return 1;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                return Diccionario::numeroDeSigla('producto_estado', (string) $value) ?? 1;
            }
        );
    }

    protected function unit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Diccionario::siglaDeNumero('producto_unidad', $value) ?? 'UNI',
            set: function ($value) {
                if ($value === null || $value === '') {
                    return 1;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                return Diccionario::numeroDeSigla('producto_unidad', (string) $value) ?? 1;
            }
        );
    }
}
