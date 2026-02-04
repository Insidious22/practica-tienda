<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_transfer_id',
        'product_id',
        'quantity_sent',
        'quantity_received',
        'unit',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity_sent' => 'decimal:3',
            'quantity_received' => 'decimal:3',
        ];
    }

    public function inventoryTransfer(): BelongsTo
    {
        return $this->belongsTo(InventoryTransfer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
