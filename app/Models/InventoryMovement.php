<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_number',
        'movement_type_id',
        'product_id',
        'source_zone_id',
        'target_zone_id',
        'quantity',
        'unit',
        'unit_cost',
        'total_cost',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'reason',
        'user_id',
        'movement_date',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'unit_cost' => 'decimal:2',
            'total_cost' => 'decimal:2',
            'stock_before' => 'decimal:3',
            'stock_after' => 'decimal:3',
            'movement_date' => 'datetime',
        ];
    }

    public function movementType(): BelongsTo
    {
        return $this->belongsTo(InventoryMovementType::class, 'movement_type_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sourceZone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'source_zone_id');
    }

    public function targetZone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'target_zone_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
