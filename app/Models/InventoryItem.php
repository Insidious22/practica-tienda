<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $table = 'inventory_items';

    protected $fillable = ['nombre', 'codigo_serie', 'cantidad'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'inventory_item_id');
    }
}
