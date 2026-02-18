<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'guardia_id',
        'inventory_item_id',
        'nombre_item',
        'codigo_serie',
    ];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    // Backward-compatible alias while old views/controllers are aligned.
    public function inventarioItem()
    {
        return $this->inventoryItem();
    }
}
