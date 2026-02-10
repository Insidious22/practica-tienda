<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'guardia_id',
        'inventario_item_id',
        'nombre_item',
        'codigo_serie',
    ];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function inventarioItem()
    {
        return $this->belongsTo(InventarioItem::class);
    }
}