<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function inventoryTransfersAsSource(): HasMany
    {
        return $this->hasMany(InventoryTransfer::class, 'source_zone_id');
    }

    public function inventoryTransfersAsTarget(): HasMany
    {
        return $this->hasMany(InventoryTransfer::class, 'target_zone_id');
    }

    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class);
    }
}
